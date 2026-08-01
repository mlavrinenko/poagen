<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\json\JsonPointer;
use cebe\openapi\spec\MediaType;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Response;
use cebe\openapi\spec\Responses;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;

use function array_keys;
use function implode;
use function sprintf;
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
 * Extracted from {@see OperationAnalyzer} to keep that file under the
 * linecop limit (ADR-004), mirroring {@see RequestBodyAnalyzer}.
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
        $content = $response->content ?? [];
        $pointer = $response->getDocumentPosition();
        $location = $pointer instanceof JsonPointer ? ' (' . $pointer->getPointer() . ')' : '';
        $prefix = sprintf('%s response%s', $status, $location);

        $json = $content['application/json'] ?? null;

        if (!$json instanceof MediaType) {
            $typeList = $content === [] ? '(none declared)' : implode(', ', array_keys($content));

            return sprintf(
                "%s content type(s) '%s' — paogen only decodes application/json responses (\$ref/list<\$ref>, "
                    . 'a scalar, or an additionalProperties map); add an application/json entry, or accept this '
                    . 'operation by name in Profile::$skip',
                $prefix,
                $typeList,
            );
        }

        $schema = $json->schema;

        if ($schema instanceof Reference) {
            return sprintf(
                "%s \$ref '%s' does not resolve to a component schema — fix or remove the \$ref",
                $prefix,
                $schema->getReference(),
            );
        }

        if (!$schema instanceof Schema) {
            return sprintf('%s declares application/json with no schema — paogen needs one to know what to decode', $prefix);
        }

        $type = SchemaType::of($schema);

        if ($type->is('array')) {
            return self::describeArray($prefix, $schema);
        }

        return sprintf(
            "%s has an application/json schema of type '%s', which paogen cannot represent as a method return type",
            $prefix,
            $type->describe(),
        );
    }

    private static function describeArray(string $prefix, Schema $schema): string
    {
        $items = $schema->items;

        if ($items instanceof Reference) {
            return sprintf(
                "%s array \$ref '%s' does not resolve to a component schema — fix or remove the \$ref",
                $prefix,
                $items->getReference(),
            );
        }

        return sprintf(
            '%s is a JSON array whose items are an inline (non-$ref) schema — paogen only emits a typed list '
                . 'for items that are a $ref to a component schema; move the item schema into components.schemas',
            $prefix,
        );
    }

    private static function fromResponse(Response $response, NameRegistry $registry): ?ReturnSpec
    {
        $content = $response->content ?? [];

        if ($content === []) {
            return ReturnSpec::void();
        }

        $json = $content['application/json'] ?? null;

        if (!$json instanceof MediaType) {
            return null;
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

        if ($type->is('object')) {
            return self::fromObject($schema);
        }

        $scalar = $type->scalarPhpType();

        return $scalar === null ? null : ReturnSpec::scalar($scalar);
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

    private static function fromObject(Schema $schema): ReturnSpec
    {
        $additional = $schema->additionalProperties;

        if ($additional instanceof Schema) {
            $valueType = SchemaType::of($additional)->scalarPhpType();

            return ReturnSpec::map($valueType ?? 'mixed');
        }

        // An inline object with declared properties never reaches here —
        // InlinePayloadPlanner synthesised a Model for it. What is left is
        // an object the document left unconstrained, and a map of unknown
        // values is what it says. Returning void instead would drop a body
        // the vendor declared, which is the shrink `silence-means-success`
        // forbids.
        return ReturnSpec::map('mixed');
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
