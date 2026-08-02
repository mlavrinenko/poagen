<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;

use function is_string;

use const SORT_STRING;

/**
 * The document-wide walk every schema-level refusal shares: each schema node
 * an operation or a component carries, visited once, with the first problem
 * found attributed to the operation or component carrying it.
 *
 * Two questions are asked of the same tree and neither owns the traversal.
 * {@see TypeListScanner} asks whether a `type` list names something PHP
 * cannot express as one type; {@see UnsupportedKeywordScanner} asks whether a
 * node uses a JSON Schema 2020-12 keyword no emitter implements. Each supplies
 * a probe and this class supplies the walk, because a second copy of the walk
 * is a second thing to keep in step — and the copy is always the one that
 * forgets `anyOf`.
 *
 * Probes are tried in order per node, so one operation reports one reason
 * rather than a pile of them: the consumer fixes the node, re-runs, and sees
 * whatever is next. Attribution goes through {@see SkippedOperation} and
 * {@see SkippedComponent} rather than throwing where the problem is found, so
 * the whole list arrives in one pass and `Profile::$skip` can accept a named
 * one (abort-on-unrepresentable-constructs, skip-is-the-only-opt-out).
 *
 * References are not followed, so the walk cannot cycle: a `$ref` node is a
 * leaf here and the component it names is visited on its own.
 *
 * @internal
 */
final readonly class SchemaScan
{
    /**
     * @param  list<callable(Schema): ?string>                                         $probes each returns a complete diagnostic
     *                                                                                         sentence for a node it refuses, or
     *                                                                                         null to let the walk carry on
     * @return array{operations: list<SkippedOperation>, components: list<SkippedComponent>}
     */
    public static function run(OpenApi $openApi, array $probes): array
    {
        return [
            'operations' => self::scanOperations($openApi, $probes),
            'components' => self::scanComponents($openApi, $probes),
        ];
    }

    /**
     * @param  list<callable(Schema): ?string> $probes
     * @return list<SkippedOperation>
     */
    private static function scanOperations(OpenApi $openApi, array $probes): array
    {
        $paths = $openApi->paths;

        if ($paths === null) {
            return [];
        }

        $items = [];

        foreach ($paths as $pathUri => $pathItem) {
            if (is_string($pathUri) && $pathItem instanceof PathItem) {
                $items[$pathUri] = $pathItem;
            }
        }

        $uris = array_keys($items);
        sort($uris, SORT_STRING);

        $out = [];

        foreach ($uris as $pathUri) {
            foreach ($items[$pathUri]->getOperations() as $httpMethod => $operation) {
                $reason = self::firstProblemIn(SchemaWalk::operationRoots($operation), $probes);

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
     * @param  list<callable(Schema): ?string> $probes
     * @return list<SkippedComponent>
     */
    private static function scanComponents(OpenApi $openApi, array $probes): array
    {
        $components = $openApi->components;

        if ($components === null) {
            return [];
        }

        /** @var array<string,Schema|Reference> $schemas */
        $schemas = $components->schemas ?? [];
        $rawNames = array_keys($schemas);
        sort($rawNames, SORT_STRING);

        $out = [];

        foreach ($rawNames as $rawName) {
            $schema = $schemas[$rawName];

            if (!$schema instanceof Schema) {
                continue;
            }

            $reason = self::firstProblemIn([$schema], $probes);

            if ($reason !== null) {
                $out[] = new SkippedComponent((string) $rawName, "component `{$rawName}`: " . $reason);
            }
        }

        return $out;
    }

    /**
     * @param list<Schema>                    $roots
     * @param list<callable(Schema): ?string> $probes
     */
    private static function firstProblemIn(array $roots, array $probes): ?string
    {
        foreach ($roots as $root) {
            $reason = self::walk($root, $probes);

            if ($reason !== null) {
                return $reason;
            }
        }

        return null;
    }

    /**
     * @param list<callable(Schema): ?string> $probes
     */
    private static function walk(Schema $schema, array $probes): ?string
    {
        foreach ($probes as $probe) {
            $reason = $probe($schema);

            if ($reason !== null) {
                return $reason;
            }
        }

        foreach (SchemaWalk::children($schema) as $child) {
            $reason = self::walk($child, $probes);

            if ($reason !== null) {
                return $reason;
            }
        }

        return null;
    }
}
