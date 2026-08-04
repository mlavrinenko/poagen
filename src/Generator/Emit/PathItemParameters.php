<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Operation;
use cebe\openapi\spec\Parameter;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;

/**
 * The parameter schemas {@see SchemaWalk} reads off a PathItem and the
 * operations beneath it.
 *
 * Split out of `SchemaWalk` itself
 * (pathitem-level-parameters-are-invisible-to-the-document-wide-scan) to
 * keep that file under linecop's line cap — the merge below mirrors
 * {@see ParameterCollector}'s override rule (an operation-level `(name,
 * in)` wins over the PathItem-level one it shares, OpenAPI 3.1 §4.8.9)
 * without resolving `$ref` parameters, which `ParameterCollector` does and
 * this walk never has.
 *
 * @internal
 */
final readonly class PathItemParameters
{
    /**
     * Every schema a PathItem's own parameters carry, once — not once per
     * operation beneath it, which {@see SchemaWalk::roots()} would yield if
     * it asked {@see ofOperation()} for every operation instead.
     *
     * @return list<Schema>
     */
    public static function ofPathItem(PathItem $pathItem): array
    {
        return self::schemas(array_values($pathItem->parameters));
    }

    /**
     * An operation's own parameter schemas, merged with what it inherits
     * from `$pathItem` when one is given; operation-only when it is not.
     *
     * @return list<Schema>
     */
    public static function ofOperation(Operation $operation, ?PathItem $pathItem): array
    {
        $own = array_values($operation->parameters ?? []);

        if (!$pathItem instanceof PathItem) {
            return self::schemas($own);
        }

        /** @var array<string,true> $claimed */
        $claimed = [];

        foreach ($own as $p) {
            if ($p instanceof Parameter) {
                $claimed[$p->name . "\0" . $p->in] = true;
            }
        }

        $inherited = [];

        foreach ($pathItem->parameters as $p) {
            if (!$p instanceof Parameter || !isset($claimed[$p->name . "\0" . $p->in])) {
                $inherited[] = $p;
            }
        }

        return self::schemas([...$inherited, ...$own]);
    }

    /**
     * A `$ref` parameter contributes nothing — same policy as {@see
     * SchemaWalk} everywhere else.
     *
     * @param  list<Parameter|Reference> $parameters
     * @return list<Schema>
     */
    private static function schemas(array $parameters): array
    {
        $out = [];

        foreach ($parameters as $p) {
            if (!$p instanceof Reference && $p->schema instanceof Schema) {
                $out[] = $p->schema;
            }
        }

        return $out;
    }
}
