<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Discriminator;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use LogicException;
use Poagen\Generator\Generator\ModelPlanner;
use Poagen\Generator\Generator\Naming\NameRegistry;
use Poagen\Generator\Generator\PropertyRenameValidator;

use function in_array;
use function is_array;
use function sprintf;

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
        // nullableOf() reads both the 3.0 flag and the 3.1 type array.
        return new TypeResolver($union, null, null, SchemaType::nullableOf($node));
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

        // nullableOf() reads both the 3.0 flag and the 3.1 type array.
        $type = SchemaType::ofMembers($members, SchemaType::nullableOf($node));

        if (!$type->isScalarUnion()) {
            return null;
        }

        // Nullability is already inside the union string — see
        // SchemaType::unionPhpType().
        return new TypeResolver($type->unionPhpType(), null, null, false);
    }

    /** A bare scalar plus an array of one — {@see ScalarOrListResolver} has the shape and the ruling. */
    public static function resolveScalarOrList(Schema $node): ?TypeResolver
    {
        $branches = self::rawBranches($node);
        if (count($branches) !== 2 || !$branches[0] instanceof Schema || !$branches[1] instanceof Schema) {
            return null;
        }

        return ScalarOrListResolver::resolve($branches[0], $branches[1], SchemaType::nullableOf($node));
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
     * Merge an `allOf` list — recursively, reading the node's own
     * `properties`/`required` too — into a single synthetic `Schema`, or a
     * PHP-union-of-branches when exactly one member is a `oneOf`/`anyOf` of
     * expressible branches. See {@see AllOfMerger} for the algorithm and
     * {@see AllOfMerge} for the three-shaped result.
     *
     * Returns null when the node has no `allOf` at all, so a caller can tell
     * "not an allOf" apart from "an allOf that merged, or refused" —
     * {@see AllOfMerge::isRefused()} carries the second distinction the
     * pre-recursion `flattenAllOf` used to erase by returning null for both.
     */
    public static function mergeAllOf(Schema $node, OpenApi $openApi): ?AllOfMerge
    {
        if (!is_array($node->allOf) || $node->allOf === []) {
            return null;
        }

        return AllOfMerger::merge($node, $openApi);
    }

    /**
     * {@see mergeAllOf}, narrowed to the single-object shape a named
     * component's `allOf` needs — neither of this method's two callers
     * (T-008's own {@see ModelPlanner}
     * dispatch, and {@see PropertyRenameValidator}
     * mirroring the same dispatch for `Profile::$propertyRenames`) has a
     * `ModelNameLedger` to register branch classes against, so a component
     * whose `allOf` merges to a `oneOf`/`anyOf` union — none in either
     * vendored corpus today — throws rather than silently picking a branch;
     * {@see InlinePayloadPlanner} is the
     * caller that can actually synthesise the branch classes an operation
     * payload's `allOf` needs.
     *
     * Returns null only when the node has no `allOf`; a present `allOf`
     * that cannot merge throws rather than returning null, closing the gap
     * where "no allOf" and "an allOf that merged to nothing" were the same
     * answer.
     */
    public static function flattenAllOf(Schema $node, OpenApi $openApi): ?Schema
    {
        $merge = self::mergeAllOf($node, $openApi);

        if (!$merge instanceof AllOfMerge) {
            return null;
        }

        if ($merge->isRefused()) {
            throw new LogicException(sprintf(
                'allOf at %s could not be merged: %s',
                SynthesisedModel::originOf($node),
                $merge->refusal ?? '',
            ));
        }

        if ($merge->isUnion()) {
            throw new LogicException(sprintf(
                'allOf at %s has a oneOf/anyOf member; a named component cannot synthesise the branch classes a '
                    . 'union body needs — see InlinePayloadPlanner for the operation-payload path that can',
                SynthesisedModel::originOf($node),
            ));
        }

        return $merge->schema;
    }

    /**
     * {@see flattenAllOf}, but a no-op `allOf` (missing or empty) returns the
     * node itself rather than null — the two callers named on
     * {@see flattenAllOf} want "the effective schema", and an object with no
     * `allOf` is already its own answer.
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
}
