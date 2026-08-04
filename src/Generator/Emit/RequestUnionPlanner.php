<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Poagen\Generator\Generator\Enum\EnumCatalog;
use Poagen\Generator\Generator\Naming\NameRegistry;

use function is_string;
use function sprintf;

/**
 * Resolves a request body whose entire schema *is* a `oneOf`/`anyOf` — the
 * "a union request body takes a union parameter" construct — into a {@see
 * BodySpec::jsonUnion()}.
 *
 * Distinct from {@see InlineAllOfPlanner}'s union handling, which resolves a
 * `oneOf`/`anyOf` sitting as one member of an `allOf`: there, every branch
 * inherits the rest of the `allOf`'s properties, so each branch is folded
 * into a full object shape before it is named. Here there is no enclosing
 * `allOf` and no folding — a branch is either already a named class (a
 * `$ref`) or stands entirely on its own (an inline object), so this planner
 * reads the branch list directly rather than routing through {@see
 * AllOfMerger}.
 *
 * Outgoing, this needs no branch *selection* at all
 * (`a-union-request-body-takes-a-union-parameter`): the caller already holds
 * a concrete instance of one branch, so the emitted parameter is simply the
 * native PHP union across every branch poagen can name as a class, and the
 * marshaller serialises whichever one it was handed.
 *
 * A schema with its own non-empty `properties` alongside a `oneOf`/`anyOf` is
 * not this construct — that pairing is a JSON Schema validation-only
 * conditional (e.g. "at least one of these fields is required"), where the
 * branches carry only `required`, or narrow a property the parent already
 * declares. The parent's own properties already describe the whole object in
 * that case, so {@see planRequest()} declines and the caller's ordinary
 * object-synthesis path is what actually resolves it. Measured on both
 * vendored corpora: every operation whose branches introduce fields the
 * parent doesn't already declare has no properties of its own, and every
 * operation with its own properties has branches that only narrow them.
 *
 * @internal
 */
final readonly class RequestUnionPlanner
{
    /**
     * @param list<SynthesisedModel> $roots
     */
    public static function planRequest(
        Schema $schema,
        string $base,
        NameRegistry $registry,
        ModelNameLedger $ledger,
        array &$roots,
        ?string &$refusal,
    ): ?BodySpec {
        $branches = AllOfMerger::rawBranches($schema);

        if ($branches === [] || ObjectShape::hasProperties($schema)) {
            return null;
        }

        // Checked in full before anything is claimed: a branch set that ends
        // up refusing must claim nothing at all, or a synthesised class for
        // an earlier, nameable branch leaks into $roots as a dangling write
        // — a file nothing in the emitted client references — for an
        // operation that never gets a method (mirrors how a pre-scanned skip
        // claims nothing at {@see InlinePayloadPlanner}'s own doc block
        // explains).
        $unnameable = self::firstUnnameableBranch($branches);

        if ($unnameable !== null) {
            [$index, $branch] = $unnameable;
            $refusal = sprintf(
                'request body branch %d at %s is %s — poagen can only union branches it can express as a PHP '
                    . 'class (a $ref to a component, or an inline object with declared properties); reduce this '
                    . 'branch to one of those, or skip the operation',
                $index,
                AllOfMerger::siteOf($branch),
                self::describeUnnameable($branch),
            );

            return null;
        }

        $models = [];
        $index = 0;

        foreach ($branches as $branch) {
            ++$index;

            $models[] = $branch instanceof Reference
                ? ComponentName::phpFromRef($branch->getReference(), $registry)
                : InlinePayloadPlanner::claim($base . self::branchLabel($branch, $index), $branch, $ledger, $roots);
        }

        return BodySpec::jsonUnion($models);
    }

    /**
     * @param array<Reference|Schema> $branches
     *
     * @return array{0:int,1:Schema}|null the 1-based branch index and node, or null when every branch is nameable
     */
    private static function firstUnnameableBranch(array $branches): ?array
    {
        $index = 0;

        foreach ($branches as $branch) {
            ++$index;

            if ($branch instanceof Reference) {
                continue;
            }

            if (InlinePayloadPlanner::isSynthesisableObject($branch)) {
                continue;
            }

            return [$index, $branch];
        }

        return null;
    }

    /**
     * A branch poagen cannot express as a PHP class: a bare `array`, a
     * scalar, or an inline object with no declared properties to synthesise
     * a class from.
     */
    private static function describeUnnameable(Schema $branch): string
    {
        if (SchemaType::of($branch)->is('array')) {
            return 'a bare `array`, not a named class';
        }

        if (ObjectShape::is($branch)) {
            return 'an inline object with no declared properties, not a named class';
        }

        return 'a `type: ' . SchemaType::of($branch)->describe() . '` schema, not a named class';
    }

    /**
     * `<TitleOrIndex>` — mirrors {@see AllOfBranchBuilder::branchLabel()} and
     * `ModelPlanner::branchLabel()`'s derivation, kept as its own copy here
     * for the same reason those two are already separate: each caller closes
     * over a different accumulator shape, and there is no shared home for the
     * derivation that does not cost more than the duplication.
     */
    private static function branchLabel(Schema $branch, int $index): string
    {
        $title = $branch->title;

        if (is_string($title) && $title !== '') {
            $pascal = EnumCatalog::pascalize($title);

            if ($pascal !== '') {
                return $pascal;
            }
        }

        return 'Branch' . $index;
    }
}
