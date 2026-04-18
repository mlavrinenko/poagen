<?php

/**
 * This file is part of mlavrinenko/paogen
 *
 * @copyright Copyright (c) Maxim Lavrinenko <maxim@lavrinenko.xyz>
 * @license https://opensource.org/license/mit/ MIT License
 */

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Operation;
use cebe\openapi\spec\Parameter;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Reference;

/**
 * Merges PathItem-level parameters with Operation-level ones and
 * resolves `$ref` nodes to concrete Parameter instances.
 *
 * Operation-level entries win on `(name, in)` collisions per
 * OpenAPI 3.0.3 §4.8.9. `null` signals an unresolvable `$ref`: the
 * caller skips the operation instead of emitting a broken method.
 *
 * @internal
 */
final readonly class ParameterCollector
{
    /**
     * @return list<Parameter>|null
     */
    public static function collect(Operation $operation, ?PathItem $pathItem): ?array
    {
        $operationParams = self::resolveAll($operation->parameters ?? []);

        if ($operationParams === null) {
            return null;
        }

        $pathParams = $pathItem instanceof \cebe\openapi\spec\PathItem ? self::resolveAll($pathItem->parameters) : [];

        if ($pathParams === null) {
            return null;
        }

        /** @var array<string,true> $seen */
        $seen = [];

        foreach ($operationParams as $p) {
            $seen[$p->name . "\0" . $p->in] = true;
        }

        $inherited = [];

        foreach ($pathParams as $p) {
            if (isset($seen[$p->name . "\0" . $p->in])) {
                continue;
            }
            $inherited[] = $p;
        }

        return [...$inherited, ...$operationParams];
    }

    /**
     * @param iterable<mixed> $raw
     *
     * @return list<Parameter>|null
     */
    private static function resolveAll(iterable $raw): ?array
    {
        $out = [];

        foreach ($raw as $param) {
            if ($param instanceof Parameter) {
                $out[] = $param;
                continue;
            }

            if (!$param instanceof Reference) {
                return null;
            }

            $resolved = $param->resolve();

            if (!$resolved instanceof Parameter) {
                return null;
            }

            $out[] = $resolved;
        }

        return $out;
    }
}
