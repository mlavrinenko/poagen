<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use Poagen\Generator\Generator\Naming\NameRegistry;
use Poagen\Generator\Generator\Naming\NormalisationContext;
use Poagen\Generator\Generator\Naming\SymbolKind;

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
        return self::phpFromRaw(self::rawFromRef($ref), $registry);
    }

    /**
     * The same resolution starting from the raw `components.schemas` key rather
     * than from a `$ref` string. A branch named in guidance — `Profile::$unionTags`,
     * `Profile::$unionPins` — arrives as the raw name, and round-tripping it
     * through a synthesised `$ref` just to get back here would be a second
     * spelling of the pointer format to keep in step.
     */
    public static function phpFromRaw(string $raw, NameRegistry $registry): string
    {
        return $registry->resolve($raw, new NormalisationContext(SymbolKind::SchemaComponent));
    }

    public static function fqcnFromRef(string $ref, string $modelNamespace, NameRegistry $registry): string
    {
        return self::fqcnFromRaw(self::rawFromRef($ref), $modelNamespace, $registry);
    }

    public static function fqcnFromRaw(string $raw, string $modelNamespace, NameRegistry $registry): string
    {
        return '\\' . trim($modelNamespace, '\\') . '\\' . self::phpFromRaw($raw, $registry);
    }
}
