<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\Enum\EnumCatalog;
use Mlavrinenko\Paogen\Generator\Enum\EnumSpec;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;

/**
 * Decides the PHP type of one model property, promoting an inline schema to a
 * named class or a backed enum where the document declared a shape but not a
 * name.
 *
 * A property whose schema is inline gets one of four readings, in order:
 *
 *   1. an inline enum paogen can back → a synthesised enum on the surrounding
 *      class plus property (`SearchClientRequestSearchMode`);
 *   2. an inline object with declared properties → a synthesised model class
 *      (`SearchClientResponseSettings`). {@see ObjectShape} decides what
 *      counts as an object, so a schema that declared properties and left the
 *      redundant `type` keyword off gets the same class it would with it;
 *   3. an inline array whose items are either of the above → the same, suffixed
 *      `Item`, with a `list<...>` phpdoc over it;
 *   4. anything else → {@see TypeResolver}, unchanged.
 *
 * The reading does not depend on where the owning schema came from. A property
 * nested in a named component and the same property nested in an operation's
 * inline response resolve identically, which is the point: a generator that
 * types one and not the other has no contract a reader can rely on.
 *
 * Extracted from {@see ModelEmitter} to keep both under the linecop limit
 * (`quality-gates-at-maximum-strictness`).
 *
 * @internal
 */
final readonly class PropertySynthesiser
{
    /**
     * @param list<SynthesisedModel> $children collects classes the caller must emit next
     */
    public function resolve(
        string $ownerClassName,
        string $phpPropName,
        Schema|Reference $propSchema,
        array &$children,
        string $modelNamespace,
        Bindings $bindings,
        NameRegistry $registry,
        ?EnumCatalog $enums,
    ): TypeResolver {
        if (!$propSchema instanceof Schema) {
            return TypeResolver::resolve($propSchema, $bindings, $modelNamespace, $registry, $enums);
        }

        $preferred = $ownerClassName . $this->suffixFor($phpPropName);
        // Same derivation as TypeResolver::resolve() — the 3.0 `nullable`
        // flag or the 3.1 `type: [T, "null"]` array — shared via
        // SchemaType::nullableOf() so the three branches below (synthesised
        // enum, synthesised object, array item) agree with TypeResolver
        // rather than reimplementing half its reading.
        $nullable = SchemaType::nullableOf($propSchema);

        $enumFqcn = $this->synthesiseEnum($preferred, $propSchema, $enums);

        if ($enumFqcn !== null) {
            return new TypeResolver($enumFqcn, null, null, $nullable);
        }

        if ($this->isSynthesisableObject($propSchema)) {
            $children[] = SynthesisedModel::forNode($preferred, $propSchema);

            return new TypeResolver('\\' . $modelNamespace . '\\' . $preferred, null, null, $nullable);
        }

        if (SchemaType::of($propSchema)->is('array')) {
            $itemType = $this->resolveArrayItem($preferred . 'Item', $propSchema, $children, $modelNamespace, $enums);

            if ($itemType !== null) {
                return new TypeResolver('array', 'list<' . $itemType . '>', $itemType, $nullable);
            }
        }

        return TypeResolver::resolve($propSchema, $bindings, $modelNamespace, $registry, $enums);
    }

    /**
     * The FQCN for an inline array's item class, or null when the items need
     * no class of their own and {@see TypeResolver} should handle the array.
     *
     * @param list<SynthesisedModel> $children
     */
    private function resolveArrayItem(
        string $itemName,
        Schema $arraySchema,
        array &$children,
        string $modelNamespace,
        ?EnumCatalog $enums,
    ): ?string {
        $items = $arraySchema->items;

        if (!$items instanceof Schema) {
            return null;
        }

        $enumFqcn = $this->synthesiseEnum($itemName, $items, $enums);

        if ($enumFqcn !== null) {
            return $enumFqcn;
        }

        if (!$this->isSynthesisableObject($items)) {
            return null;
        }

        $children[] = SynthesisedModel::forNode($itemName, $items);

        return '\\' . $modelNamespace . '\\' . $itemName;
    }

    private function isSynthesisableObject(Schema $schema): bool
    {
        return ObjectShape::is($schema) && InlineObjectResolver::isSynthesisable($schema);
    }

    /**
     * PascalCase the property name before it becomes part of a class name. A
     * PHP property may legally stay `activate_client_type`, and the model keeps
     * it that way because it is the wire name; a class called
     * `SearchClientResponseActivate_client_type` is a different matter. Same
     * derivation {@see ParameterAdder} already uses for a parameter's inline
     * enum, so the two agree.
     */
    private function suffixFor(string $phpPropName): string
    {
        $pascal = EnumCatalog::pascalize($phpPropName);

        return $pascal === '' ? ucfirst($phpPropName) : $pascal;
    }

    /**
     * Register an inline enum under the derived name and return its FQCN, or
     * null when the schema is not one paogen can back — a mixed-type or
     * null-carrying `enum` list stays on its base type rather than becoming a
     * partial enum that silently drops cases.
     */
    private function synthesiseEnum(string $preferredName, Schema $schema, ?EnumCatalog $enums): ?string
    {
        if (!$enums instanceof EnumCatalog) {
            return null;
        }

        $spec = EnumCatalog::specFromSchema($preferredName, $schema);

        if (!$spec instanceof EnumSpec) {
            return null;
        }

        $enums->synthesize($preferredName, $spec);

        return $enums->synthesizedFqcn($preferredName);
    }
}
