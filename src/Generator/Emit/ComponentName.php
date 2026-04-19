<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Mlavrinenko\Paogen\Generator\Naming\NormalisationContext;
use Mlavrinenko\Paogen\Generator\Naming\SymbolKind;

/**
 * Single point where every emitter resolves an OpenAPI ref target
 * into a PHP class name. Replaces the per-class `componentNameFromRef`
 * helpers that scattered across the Emit/ tree (T-023).
 */
final readonly class ComponentName
{
    public static function rawFromRef(string $ref): string
    {
        $parts = explode('/', $ref);
        $last = end($parts);

        return $last === false ? '' : $last;
    }

    public static function phpFromRef(string $ref, NameRegistry $registry): string
    {
        return $registry->resolve(
            self::rawFromRef($ref),
            new NormalisationContext(SymbolKind::SchemaComponent),
        );
    }

    public static function fqcnFromRef(string $ref, string $modelNamespace, NameRegistry $registry): string
    {
        return '\\' . trim($modelNamespace, '\\') . '\\' . self::phpFromRef($ref, $registry);
    }
}
