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

/**
 * Finds every schema node whose `type` names several types that PHP cannot
 * express as one, and attributes each to the operation or component that
 * carries it.
 *
 * `type: [string, integer]` is representable — PHP says `string|int` — and
 * {@see SchemaType} handles it. `type: [object, string]` is not: there is no
 * single class for an inline object member and no single item type for an array
 * member, so any type paogen emitted would be a guess or `mixed`.
 *
 * The finding has to reach the run through the same channel as every other
 * refusal rather than throwing where it is found, for two reasons that
 * `abort-on-unrepresentable-constructs` settled: a consumer fixing their
 * document should see the whole list in one pass, and `Profile::$skip` has to
 * be able to accept a named one. So this reports {@see SkippedOperation} and
 * {@see SkippedComponent} values, and the operation is not emitted rather than
 * being emitted *and* reported.
 *
 * References are not followed, so the walk cannot cycle: a `$ref` node is a
 * leaf here and the component it names is visited on its own.
 *
 * @internal
 */
final readonly class TypeListScanner
{
    /**
     * @return array{operations: list<SkippedOperation>, components: list<SkippedComponent>}
     */
    public static function scan(OpenApi $openApi): array
    {
        return [
            'operations' => self::scanOperations($openApi),
            'components' => self::scanComponents($openApi),
        ];
    }

    /**
     * @return list<SkippedOperation>
     */
    private static function scanOperations(OpenApi $openApi): array
    {
        $paths = $openApi->paths;

        if ($paths === null) {
            return [];
        }

        $items = [];

        foreach ($paths as $pathUri => $pathItem) {
            if (\is_string($pathUri) && $pathItem instanceof PathItem) {
                $items[$pathUri] = $pathItem;
            }
        }

        $uris = array_keys($items);
        sort($uris, \SORT_STRING);

        $out = [];

        foreach ($uris as $pathUri) {
            foreach ($items[$pathUri]->getOperations() as $httpMethod => $operation) {
                $reason = self::firstProblemIn(self::schemasOf($operation));

                if ($reason === null) {
                    continue;
                }

                $out[] = new SkippedOperation(
                    (string) $httpMethod,
                    $pathUri,
                    (string) ($operation->operationId ?? ''),
                    $reason,
                );
            }
        }

        return $out;
    }

    /**
     * @return list<SkippedComponent>
     */
    private static function scanComponents(OpenApi $openApi): array
    {
        $components = $openApi->components;

        if ($components === null) {
            return [];
        }

        /** @var array<string,Schema|Reference> $schemas */
        $schemas = $components->schemas ?? [];
        $rawNames = array_keys($schemas);
        sort($rawNames, \SORT_STRING);

        $out = [];

        foreach ($rawNames as $rawName) {
            $schema = $schemas[$rawName];

            if (!$schema instanceof Schema) {
                continue;
            }

            $reason = self::firstProblemIn([$schema]);

            if ($reason !== null) {
                $out[] = new SkippedComponent((string) $rawName, "component `{$rawName}`: " . $reason);
            }
        }

        return $out;
    }

    /**
     * Every schema node an operation carries directly: request-body media
     * types, every response's media types, and every parameter.
     *
     * @return list<Schema>
     */
    private static function schemasOf(Operation $operation): array
    {
        $out = [];
        $body = RequestBodyAnalyzer::resolveBody($operation->requestBody);

        foreach ($body instanceof RequestBody ? $body->content : [] as $media) {
            if ($media->schema instanceof Schema) {
                $out[] = $media->schema;
            }
        }

        $responses = $operation->responses;

        foreach ($responses === null ? [] : $responses->getResponses() as $response) {
            if (!$response instanceof Response) {
                continue;
            }

            foreach ($response->content as $media) {
                if ($media->schema instanceof Schema) {
                    $out[] = $media->schema;
                }
            }
        }

        foreach ($operation->parameters ?? [] as $parameter) {
            if (!$parameter instanceof Reference && $parameter->schema instanceof Schema) {
                $out[] = $parameter->schema;
            }
        }

        return $out;
    }

    /**
     * @param list<Schema> $roots
     */
    private static function firstProblemIn(array $roots): ?string
    {
        foreach ($roots as $root) {
            $reason = self::walk($root);

            if ($reason !== null) {
                return $reason;
            }
        }

        return null;
    }

    private static function walk(Schema $schema): ?string
    {
        $type = SchemaType::of($schema);

        if ($type->isUnrepresentable()) {
            return \sprintf(
                'schema at %s declares `type: [%s]` — paogen emits a PHP union for a list of scalar types, but a '
                    . 'list mixing `object` or `array` with anything else has no single PHP type: an inline object '
                    . 'member needs a class of its own and an array member needs one item type. Split it into a '
                    . '`oneOf` of named component schemas, or narrow it to one type',
                SynthesisedModel::originOf($schema),
                $type->describe(),
            );
        }

        foreach (\is_array($schema->properties) ? $schema->properties : [] as $property) {
            if ($property instanceof Schema && ($reason = self::walk($property)) !== null) {
                return $reason;
            }
        }

        foreach ([$schema->items, $schema->additionalProperties] as $child) {
            if ($child instanceof Schema && ($reason = self::walk($child)) !== null) {
                return $reason;
            }
        }

        foreach (self::compositionBranches($schema) as $branch) {
            if ($branch instanceof Schema && ($reason = self::walk($branch)) !== null) {
                return $reason;
            }
        }

        return null;
    }

    /**
     * @return list<Schema|Reference>
     */
    private static function compositionBranches(Schema $schema): array
    {
        $out = [];

        foreach ([$schema->allOf, $schema->oneOf, $schema->anyOf] as $branches) {
            if (\is_array($branches)) {
                $out = [...$out, ...array_values($branches)];
            }
        }

        return $out;
    }
}
