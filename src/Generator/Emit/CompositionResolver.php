<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Discriminator;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;

use function in_array;
use function is_array;

/**
 * Resolution strategy for composition keywords `oneOf`, `anyOf`, `allOf`
 * (T-008). Mirrors {@see InlineObjectResolver} in tone: a small stateless
 * helper the {@see TypeResolver} / {@see Generator} dispatch to.
 *
 * Scope for the first cut:
 *
 * 1. `oneOf` / `anyOf` of `$ref`-ed components → PHP 8 union type (e.g.
 *    `Dog|Cat`) plus a PROPERTY_MAP `['union', [A, B], ?discriminator]`
 *    tuple so the hydrator can pick the right class.
 * 2. `allOf` of object schemas (inline or `$ref`) → inline-merged
 *    `Schema` whose `properties` and `required` are the union of the
 *    branches, with later entries winning on conflict (cebe parser
 *    semantics).
 *
 * Out of scope: `discriminator.mapping` inversion, `not`, recursive
 * composition. See `truth/tasks/008-composition-oneof-anyof-allof.typ`.
 *
 * @internal
 */
final class CompositionResolver
{
    /**
     * Resolve a schema whose `oneOf` or `anyOf` is a list of `$ref`s to
     * named components into a PHP 8 union type. Returns null for shapes
     * the first cut does not model (e.g. a branch that is not a ref).
     */
    public static function resolveUnion(
        Schema $node,
        string $modelNamespace,
        NameRegistry $registry,
    ): ?TypeResolver {
        $branches = self::unionBranches($node);

        if ($branches === null) {
            return null;
        }

        $fqcns = self::branchFqcns($branches, $modelNamespace, $registry);
        $union = implode('|', $fqcns);

        // Native union already expresses the alternative — no PHPDoc mirror.
        return new TypeResolver($union, null, null, (bool) $node->nullable);
    }

    /**
     * Resolve a schema whose `oneOf`/`anyOf` lists inline scalar schemas —
     * e.g. `anyOf: [{type: integer}, {type: string}]`, DigitalOcean's
     * `image_id` shape — into the PHP union those scalars share. This is
     * the composition spelling of a scalar union; {@see
     * SchemaType::isScalarUnion()} already covers the `type: [integer,
     * string]` list spelling of the same idea, and this method exists so
     * the two spellings resolve the same way instead of one of them
     * falling through to `mixed`.
     *
     * Returns null — deferring to another strategy, or ultimately to
     * `mixed` — for anything this narrow reading does not cover: a `$ref`
     * branch, a branch that is not a single bare scalar type, or fewer
     * than two branches.
     */
    public static function resolveScalarUnion(Schema $node): ?TypeResolver
    {
        $branches = self::rawBranches($node);

        if (count($branches) < 2) {
            return null;
        }

        $members = [];

        foreach ($branches as $branch) {
            if (!$branch instanceof Schema) {
                return null;
            }

            $scalar = SchemaType::of($branch)->scalarName();

            if ($scalar === null) {
                return null;
            }

            if (!in_array($scalar, $members, true)) {
                $members[] = $scalar;
            }
        }

        $type = SchemaType::ofMembers($members, (bool) $node->nullable);

        if (!$type->isScalarUnion()) {
            return null;
        }

        // Nullability is already inside the union string — see
        // SchemaType::unionPhpType().
        return new TypeResolver($type->unionPhpType(), null, null, false);
    }

    /**
     * Build the PROPERTY_MAP shape tuple for a `oneOf`/`anyOf` union.
     * Returns null when the schema is not a ref-only union.
     *
     * @return array{0:'union',1:list<string>,2:?string}|null
     */
    public static function shapeForUnion(
        Schema $node,
        string $modelNamespace,
        NameRegistry $registry,
    ): ?array {
        $branches = self::unionBranches($node);

        if ($branches === null) {
            return null;
        }

        $fqcns = self::branchFqcns($branches, $modelNamespace, $registry);
        $discriminator = $node->discriminator;
        $property = $discriminator instanceof Discriminator ? $discriminator->propertyName : null;

        return ['union', $fqcns, $property];
    }

    /**
     * Merge an `allOf` branch list into a single synthetic `Schema` whose
     * `properties`/`required` are the union of the branches. Later entries
     * win on conflict. `$ref` branches are resolved against
     * `$openApi->components->schemas`; non-object branches are ignored.
     */
    public static function flattenAllOf(Schema $node, OpenApi $openApi): ?Schema
    {
        /** @var array<Schema|Reference> $branches */
        $branches = $node->allOf ?? [];

        if ($branches === []) {
            return null;
        }

        /** @var array<string,Schema|Reference> $merged */
        $merged = [];
        /** @var list<string> $required */
        $required = [];

        foreach ($branches as $branch) {
            $target = self::resolveBranchSchema($branch, $openApi);

            if (!$target instanceof Schema) {
                continue;
            }

            /** @var array<string,Schema|Reference> $props */
            $props = $target->properties ?? [];

            foreach ($props as $k => $v) {
                $merged[$k] = $v;
            }

            /** @var list<string> $req */
            $req = $target->required ?? [];

            foreach ($req as $name) {
                if (!in_array($name, $required, true)) {
                    $required[] = $name;
                }
            }
        }

        if ($merged === []) {
            return null;
        }

        return new Schema([
            'type' => 'object',
            'properties' => $merged,
            'required' => $required,
        ]);
    }

    /**
     * {@see flattenAllOf}, but a no-op `allOf` (missing or empty) returns the
     * node itself rather than null — the caller (T-008's own {@see
     * \Mlavrinenko\Paogen\Generator\ModelPlanner} dispatch, and {@see
     * \Mlavrinenko\Paogen\Generator\PropertyRenameValidator} mirroring the
     * same dispatch for `Profile::$propertyRenames`) wants "the effective
     * schema", and an object with no `allOf` is already its own answer.
     */
    public static function materialiseAllOf(Schema $schema, OpenApi $openApi): ?Schema
    {
        if (!is_array($schema->allOf) || $schema->allOf === []) {
            return $schema;
        }

        return self::flattenAllOf($schema, $openApi);
    }

    /**
     * The raw `oneOf` or `anyOf` branch list, `oneOf` preferred when a
     * schema declares both. Empty when the schema uses neither keyword.
     *
     * @return array<Schema|Reference>
     */
    private static function rawBranches(Schema $node): array
    {
        /** @var array<Schema|Reference> $oneOf */
        $oneOf = $node->oneOf ?? [];
        /** @var array<Schema|Reference> $anyOf */
        $anyOf = $node->anyOf ?? [];

        return $oneOf !== [] ? $oneOf : $anyOf;
    }

    /**
     * Extract the branch list from a ref-only `oneOf` or `anyOf`. Returns
     * null when the schema doesn't model that shape.
     *
     * @return list<Reference>|null
     */
    private static function unionBranches(Schema $node): ?array
    {
        $branches = self::rawBranches($node);

        if ($branches === []) {
            return null;
        }

        $refs = [];

        foreach ($branches as $branch) {
            if (!$branch instanceof Reference) {
                return null;
            }

            $refs[] = $branch;
        }

        return $refs;
    }

    /**
     * @param list<Reference> $branches
     *
     * @return list<string>
     */
    private static function branchFqcns(array $branches, string $modelNamespace, NameRegistry $registry): array
    {
        $out = [];

        foreach ($branches as $ref) {
            $out[] = ComponentName::fqcnFromRef($ref->getReference(), $modelNamespace, $registry);
        }

        return $out;
    }

    private static function resolveBranchSchema(Schema|Reference $branch, OpenApi $openApi): ?Schema
    {
        if ($branch instanceof Schema) {
            return $branch;
        }

        $name = ComponentName::rawFromRef($branch->getReference());
        $components = $openApi->components;

        if ($components === null) {
            return null;
        }

        /** @var array<string,Schema|Reference> $schemas */
        $schemas = $components->schemas ?? [];
        $target = $schemas[$name] ?? null;

        if ($target instanceof Schema) {
            return $target;
        }

        return null;
    }
}
