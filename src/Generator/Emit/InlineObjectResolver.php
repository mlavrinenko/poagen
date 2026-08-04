<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Poagen\Generator\Generator\Bindings;
use Poagen\Generator\Generator\Enum\EnumCatalog;
use Poagen\Generator\Generator\Naming\NameRegistry;

/**
 * Resolution strategy for an inline object schema (T-013).
 *
 * Two cases, and which one applies is decided by
 * {@see self::isSynthesisable()}:
 *
 * 1. Declared `properties` → caller must synthesise a named class; this
 *    helper never returns an FQCN, it only classifies. {@see ModelEmitter}
 *    handles the synthesis because it owns the owning-class/property
 *    context used to build the synthesised name. A value schema under
 *    `additionalProperties` does not change that answer — the class carries
 *    the declared properties *and* the extra keys, which
 *    {@see AdditionalPropertyEmitter} adds as a typed map.
 * 2. No declared properties → a string-keyed map, typed by
 *    `additionalProperties` where the document supplied a schema for it
 *    (`array<string, Pet>`) and `array<string, mixed>` where it did not.
 *    A map is a collection, so a PHP array is what it is —
 *    `declared-shapes-become-types` keeps those as arrays on purpose.
 *
 * The third case this file used to carry — declared properties *and* a
 * non-trivial `additionalProperties`, answered with `array<string, mixed>`
 * and a `@todo` — discarded every declared property. It is gone; case (1)
 * covers it.
 *
 * @internal
 */
final class InlineObjectResolver
{
    /**
     * Type an inline object with no declared properties as a string-keyed map.
     * {@see ModelEmitter} calls {@see self::isSynthesisable} before dispatching
     * to this fallback, so a schema with declared properties never reaches here.
     */
    public static function resolve(
        Schema $node,
        Bindings $bindings,
        string $modelNamespace,
        NameRegistry $registry,
        ?EnumCatalog $enums,
    ): TypeResolver {
        // 3.0 `nullable: true` or 3.1 `type: [T, "null"]` — read once, shared
        // with TypeResolver and PropertySynthesiser via SchemaType.
        $nullable = SchemaType::nullableOf($node);
        $phpDoc = self::valueMapDoc($node, $bindings, $modelNamespace, $registry, $enums);

        return new TypeResolver('array', $phpDoc, null, $nullable);
    }

    /**
     * True when the schema declares properties and should be promoted to a
     * named class rather than flattened into a map.
     */
    public static function isSynthesisable(Schema $node): bool
    {
        return ObjectShape::hasProperties($node);
    }

    /**
     * `array<string, T>` for the schema's extra keys, where `T` is whatever
     * `additionalProperties` declared — a `$ref` to a component, a nested
     * object, a list, a scalar — resolved by the same {@see TypeResolver}
     * every other position uses. `array<string, mixed>` when the document
     * gave no schema for the values, which is the one honest `mixed`.
     */
    public static function valueMapDoc(
        Schema $node,
        Bindings $bindings,
        string $modelNamespace,
        NameRegistry $registry,
        ?EnumCatalog $enums,
    ): string {
        $additional = $node->additionalProperties;

        if (!($additional instanceof Schema) && !($additional instanceof Reference)) {
            return 'array<string, mixed>';
        }

        $resolved = TypeResolver::resolve($additional, $bindings, $modelNamespace, $registry, $enums);
        $docItem = $resolved->phpDoc ?? ($resolved->phpType ?? 'mixed');

        return 'array<string, ' . $docItem . '>';
    }
}
