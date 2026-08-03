<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\RequestBody;
use cebe\openapi\spec\Response;
use cebe\openapi\spec\Schema;

use function is_array;
use function is_string;

/**
 * Where a document's schema nodes are, and what hangs below each one.
 *
 * Three passes asked the same two questions and each answered them itself:
 * {@see SchemaScan} for the refusal probes, {@see FormatAdvisor} for the
 * unrecognised-format report, {@see UnconstrainedFieldAdvisor} for the
 * unconstrained-value report. The copies were identical, which meant three
 * places to forget `anyOf` in — and the copy that forgets is always the one
 * nobody is looking at. The traversal lives here; each caller keeps only what
 * it does per node.
 *
 * References are not followed, so a walk cannot cycle: a `$ref` node is a leaf
 * and the component it names is a root of its own.
 *
 * @internal
 */
final readonly class SchemaWalk
{
    /**
     * Every schema root in the document: named components, and each
     * operation's body, responses and parameters.
     *
     * @return list<Schema>
     */
    public static function roots(OpenApi $openApi): array
    {
        $out = [];
        $components = $openApi->components;

        /** @var array<string,Schema|Reference> $schemas */
        $schemas = $components === null ? [] : ($components->schemas ?? []);

        foreach ($schemas as $schema) {
            if ($schema instanceof Schema) {
                $out[] = $schema;
            }
        }

        foreach ($openApi->paths ?? [] as $pathItem) {
            if (!$pathItem instanceof PathItem) {
                continue;
            }

            foreach ($pathItem->getOperations() as $operation) {
                $out = [...$out, ...self::operationRoots($operation)];
            }
        }

        return $out;
    }

    /**
     * Every schema node one operation carries directly: request-body media
     * types, every response's media types, and every parameter.
     *
     * @return list<Schema>
     */
    public static function operationRoots(Operation $operation): array
    {
        $out = [];

        foreach (self::bodyContentSchemas($operation) as [, $schema]) {
            $out[] = $schema;
        }

        foreach ($operation->parameters ?? [] as $parameter) {
            if (!$parameter instanceof Reference && $parameter->schema instanceof Schema) {
                $out[] = $parameter->schema;
            }
        }

        return $out;
    }

    /**
     * Every schema a request body or a response carries directly under a
     * content-type key, paired with that key — the exact (media type,
     * schema) pair {@see BodyMediaType} classifies. Parameters are not
     * included: nothing there is ever read as a body payload.
     *
     * References are not followed here either, same as everywhere else in
     * this class — a `$ref` request/response body never reaches {@see
     * BodyMediaType} as a Schema (its callers all guard `instanceof
     * Schema`), so it is right that this does not manufacture one.
     *
     * @return list<array{string, Schema}>
     */
    public static function bodyContentSchemas(Operation $operation): array
    {
        $out = [];
        $body = RequestBodyAnalyzer::resolveBody($operation->requestBody);

        foreach ($body instanceof RequestBody ? $body->content : [] as $mediaType => $media) {
            if (is_string($mediaType) && $media->schema instanceof Schema) {
                $out[] = [$mediaType, $media->schema];
            }
        }

        $responses = $operation->responses;

        foreach ($responses === null ? [] : $responses->getResponses() as $response) {
            if (!$response instanceof Response) {
                continue;
            }

            foreach ($response->content as $mediaType => $media) {
                if (is_string($mediaType) && $media->schema instanceof Schema) {
                    $out[] = [$mediaType, $media->schema];
                }
            }
        }

        return $out;
    }

    /**
     * Every body/response content schema in the whole document, paired with
     * its media type — {@see bodyContentSchemas()} run over every operation,
     * for {@see FormatAdvisor} to check against {@see BodyMediaType} without
     * re-deriving which schemas request/response bodies carry.
     *
     * @return list<array{string, Schema}>
     */
    public static function bodySchemas(OpenApi $openApi): array
    {
        $out = [];

        foreach ($openApi->paths ?? [] as $pathItem) {
            if (!$pathItem instanceof PathItem) {
                continue;
            }

            foreach ($pathItem->getOperations() as $operation) {
                $out = [...$out, ...self::bodyContentSchemas($operation)];
            }
        }

        return $out;
    }

    /**
     * The schema nodes hanging directly below one node, in the order a reader
     * would meet them: declared properties, the item and value schemas, then
     * every composition branch.
     *
     * @return list<Schema>
     */
    public static function children(Schema $schema): array
    {
        $out = [];

        foreach (is_array($schema->properties) ? $schema->properties : [] as $property) {
            if ($property instanceof Schema) {
                $out[] = $property;
            }
        }

        foreach ([$schema->items, $schema->additionalProperties] as $child) {
            if ($child instanceof Schema) {
                $out[] = $child;
            }
        }

        foreach (self::compositionBranches($schema) as $branch) {
            if ($branch instanceof Schema) {
                $out[] = $branch;
            }
        }

        return $out;
    }

    /**
     * Every `allOf` / `oneOf` / `anyOf` branch on one node, in that order.
     *
     * `devizzent/cebe-php-openapi` declares all three as `Schema[]|Reference[]`,
     * and the accessor answers `null` for a keyword the document never wrote —
     * the same gap {@see SchemaType::rawType()} widens for `type`. A reader
     * that trusted the declaration would drop the `is_array` guard and fatal on
     * the first schema with no composition, which is most of them. The guard is
     * here once so no caller has to know that.
     *
     * @return list<Schema|Reference>
     */
    public static function compositionBranches(Schema $schema): array
    {
        $out = [];

        foreach ([$schema->allOf, $schema->oneOf, $schema->anyOf] as $branches) {
            if (is_array($branches)) {
                $out = [...$out, ...array_values($branches)];
            }
        }

        return $out;
    }

    /**
     * Just the alternation branches — `oneOf` when a schema declares it,
     * `anyOf` otherwise — with the same `is_array` guard, and never `allOf`.
     *
     * {@see compositionBranches} deliberately flattens all three, which is what
     * a walk wants and what a branch *selector* must not have: folding `allOf`
     * in would treat a schema's own composed parts as alternatives to each
     * other. Both readings are needed, so both live here rather than one caller
     * re-deriving the keywords and re-learning the null.
     *
     * @return list<Schema|Reference>
     */
    public static function oneOfOrAnyOf(Schema $schema): array
    {
        $oneOf = is_array($schema->oneOf) ? array_values($schema->oneOf) : [];

        if ($oneOf !== []) {
            return $oneOf;
        }

        return is_array($schema->anyOf) ? array_values($schema->anyOf) : [];
    }
}
