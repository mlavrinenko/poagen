<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\Enum\EnumCatalog;

/**
 * Resolution strategy for an inline `type: object` schema (T-013).
 *
 * Three cases, in order:
 *
 * 1. Declared `properties` → caller must synthesise a named class; this
 *    helper never returns an FQCN, it only classifies. {@see ModelEmitter}
 *    handles the synthesis because it owns the owning-class/property
 *    context used to build the synthesised name.
 * 2. Only `additionalProperties: <scalar>` and no declared properties →
 *    typed map `array<string, <scalar>>`.
 * 3. Anything else (both, opaque, or empty) → untyped map
 *    `array<string, mixed>` with a `@todo` near the property when
 *    both declared properties and non-trivial additionalProperties
 *    coexist.
 *
 * @internal
 */
final class InlineObjectResolver
{
    /**
     * Classify the inline-object case without synthesising a class.
     * {@see ModelEmitter} calls {@see self::classify} before dispatching
     * to this fallback so that case (1) never reaches here.
     */
    public static function resolve(
        Schema $node,
        Bindings $bindings,
        string $modelNamespace,
        ?EnumCatalog $enums,
    ): TypeResolver {
        $nullable = (bool) $node->nullable;
        $phpDoc = self::additionalPropertiesDoc($node, $bindings, $modelNamespace, $enums);

        return new TypeResolver('array', $phpDoc, null, $nullable);
    }

    /**
     * Classify an inline-object schema into one of three cases.
     *
     * Returns `'synthesise'` when the schema has declared properties and
     * should be promoted to a named class; `'map-todo'` when it has both
     * declared properties and non-trivial `additionalProperties` (fall
     * back to `array<string, mixed>` with a `@todo`); otherwise
     * `'typed-map'` (case 2 or 3).
     *
     * @return 'synthesise'|'map-todo'|'typed-map'
     */
    public static function classify(Schema $node): string
    {
        $hasProperties = \is_array($node->properties) && $node->properties !== [];
        $additional = $node->additionalProperties;
        $hasNonTrivialAdditional = $additional instanceof Schema || $additional instanceof Reference;

        if ($hasProperties && $hasNonTrivialAdditional) {
            return 'map-todo';
        }

        if ($hasProperties) {
            return 'synthesise';
        }

        return 'typed-map';
    }

    private static function additionalPropertiesDoc(
        Schema $node,
        Bindings $bindings,
        string $modelNamespace,
        ?EnumCatalog $enums,
    ): string {
        $additional = $node->additionalProperties;

        if (!($additional instanceof Schema) && !($additional instanceof Reference)) {
            return 'array<string, mixed>';
        }

        $resolved = TypeResolver::resolve($additional, $bindings, $modelNamespace, $enums);
        $docItem = $resolved->phpDoc ?? ($resolved->phpType ?? 'mixed');

        return 'array<string, ' . $docItem . '>';
    }
}
