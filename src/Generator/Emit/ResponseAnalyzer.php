<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\MediaType;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Response;
use cebe\openapi\spec\Responses;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;

use function str_starts_with;

/**
 * Resolves the picked 2xx response of an OpenAPI Operation into a
 * {@see ReturnSpec}.
 *
 * `null` means this response sits outside paogen's supported shapes and the
 * caller must refuse the operation rather than fall back to `void` — a
 * response that declares a body and gets one dropped is exactly the silent
 * shrink `silence-means-success` forbids (default-deny-on-degradation).
 * `void` is returned only when the document itself declares no body: no
 * `Responses` object at all, no 2xx status entry, or a 2xx entry whose
 * `content` is empty.
 *
 * Two shapes reach a return type: an `application/json` body, resolved by
 * its schema, and a body the document declared as text over a `type: string`
 * schema, which is the `string` it says it is. A binary body is neither and
 * stays refused.
 *
 * Extracted from {@see OperationAnalyzer} to keep that file under the
 * linecop limit (`quality-gates-at-maximum-strictness`), mirroring
 * {@see RequestBodyAnalyzer}; the diagnostics half moved on to
 * {@see ResponseRefusal} for the same reason.
 *
 * @internal
 */
final readonly class ResponseAnalyzer
{
    /**
     * @param Responses<Response|Reference>|null $responses
     */
    public static function resolve(?Responses $responses, NameRegistry $registry): ?ReturnSpec
    {
        $picked = self::pick2xx($responses);

        if ($picked === null) {
            return ReturnSpec::void();
        }

        return self::fromResponse($picked[1], $registry);
    }

    /**
     * Explains why {@see resolve()} returned null for an operation whose 2xx
     * response was picked — names the status, the content type(s) found,
     * and what would make the response acceptable.
     *
     * @param Responses<Response|Reference>|null $responses
     */
    public static function describeUnsupported(?Responses $responses): string
    {
        $picked = self::pick2xx($responses);

        if ($picked === null) {
            return "this operation's 2xx response could not be re-located to describe — this should not happen";
        }

        [$status, $response] = $picked;

        return ResponseRefusal::describe($status, $response, $response->content ?? []);
    }

    private static function fromResponse(Response $response, NameRegistry $registry): ?ReturnSpec
    {
        $content = $response->content ?? [];

        if ($content === []) {
            return ReturnSpec::void();
        }

        $json = $content['application/json'] ?? null;

        if (!$json instanceof MediaType) {
            return self::textResponse($content);
        }

        $schema = $json->schema;

        if ($schema instanceof Reference) {
            $ref = $schema->getReference();
            $raw = ComponentName::rawFromRef($ref);

            return $raw === '' ? null : ReturnSpec::model(ComponentName::phpFromRef($ref, $registry));
        }

        if (!$schema instanceof Schema) {
            return null;
        }

        $type = SchemaType::of($schema);

        if ($type->is('array')) {
            return self::fromArray($schema, $registry);
        }

        if (ObjectShape::is($schema)) {
            return self::fromObject($schema, $registry);
        }

        $scalar = $type->scalarPhpType();

        return $scalar === null ? null : ReturnSpec::scalar($scalar);
    }

    /**
     * A 2xx response the document declared as characters rather than as JSON.
     *
     * It reaches the caller as the `string` the schema said it was, read
     * straight off the body — {@see ReturnSpec::scalar()} already means
     * "no JSON decode", which is exactly right for `text/html` and for
     * GitHub's `application/octocat-stream`. No Model, no ambiguity, and
     * nothing about it needs a return kind of its own.
     *
     * A binary response is deliberately not accepted here: a
     * `format: binary` body is a stream, not a string, and casting one to
     * the other is the silent widening `declared-shapes-become-types`
     * refuses. It stays a refusal until the return contract can name a
     * stream.
     *
     * @param array<array-key, MediaType> $content
     */
    private static function textResponse(array $content): ?ReturnSpec
    {
        return BodyMediaType::firstText($content) === null ? null : ReturnSpec::scalar('string');
    }

    private static function fromArray(Schema $schema, NameRegistry $registry): ?ReturnSpec
    {
        $items = $schema->items;

        if (!$items instanceof Reference) {
            return null;
        }

        $ref = $items->getReference();
        $raw = ComponentName::rawFromRef($ref);

        return $raw === '' ? null : ReturnSpec::listOf(ComponentName::phpFromRef($ref, $registry));
    }

    /**
     * An object response, as the map its `additionalProperties` describes.
     *
     * The comment that stood here claimed an inline object with declared
     * properties never reached this method because `InlinePayloadPlanner`
     * had synthesised a Model for it. That was false: the planner declined
     * any schema mixing declared properties with a non-trivial
     * `additionalProperties`, and every such response landed here and lost
     * its properties without a word. The planner now synthesises that shape
     * too, so what arrives here really is an object with no properties to
     * name — but the claim is stated as a consequence of the planner's rule
     * rather than as a promise, because it was believed once already.
     */
    private static function fromObject(Schema $schema, NameRegistry $registry): ReturnSpec
    {
        return ReturnSpec::map(self::mapValue($schema->additionalProperties, $registry));
    }

    /**
     * The shape of one map's values, resolved to whatever the document
     * declared for them: a component, a list of components, a scalar, or a
     * nested map. The request side has resolved all of these through
     * {@see TypeResolver} since it was written; reading only
     * `scalarPhpType()` here is what made the same construct answer `Pet` in
     * a body and `mixed` in a response.
     *
     * `mixed` survives exactly where the document said nothing about the
     * values, which {@see UnconstrainedFieldAdvisor} reports on the run.
     */
    private static function mapValue(Schema|Reference|bool $additional, NameRegistry $registry): ReturnSpec
    {
        if ($additional instanceof Reference) {
            $raw = ComponentName::rawFromRef($additional->getReference());

            return $raw === '' ? ReturnSpec::mixed() : ReturnSpec::model(ComponentName::phpFromRef($additional->getReference(), $registry));
        }

        if (!$additional instanceof Schema) {
            return ReturnSpec::mixed();
        }

        $scalar = SchemaType::of($additional)->scalarPhpType();

        if ($scalar !== null) {
            return ReturnSpec::scalar($scalar);
        }

        if (SchemaType::of($additional)->is('array')) {
            $items = $additional->items;

            return $items instanceof Reference
                ? ReturnSpec::listOf(ComponentName::phpFromRef($items->getReference(), $registry))
                : ReturnSpec::mixed();
        }

        return ObjectShape::is($additional)
            ? ReturnSpec::map(self::mapValue($additional->additionalProperties, $registry))
            : ReturnSpec::mixed();
    }

    /**
     * @param  Responses<Response|Reference>|null $responses
     * @return array{0:string,1:Response}|null
     */
    private static function pick2xx(?Responses $responses): ?array
    {
        if (!$responses instanceof Responses) {
            return null;
        }

        foreach ($responses->getResponses() as $status => $response) {
            if (!str_starts_with((string) $status, '2')) {
                continue;
            }
            if (!$response instanceof Response) {
                continue;
            }

            return [(string) $status, $response];
        }

        return null;
    }
}
