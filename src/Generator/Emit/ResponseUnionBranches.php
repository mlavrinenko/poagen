<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Poagen\Generator\Generator\Enum\EnumCatalog;
use Poagen\Generator\Generator\Naming\NameRegistry;
use Poagen\Generator\Generator\UnionGuidanceValidator;

use function array_map;
use function is_string;
use function sprintf;

/**
 * Names every branch of a response-position `oneOf`/`anyOf`, and the shape
 * {@see BranchSelectors} needs for each one.
 *
 * A `$ref` branch already has a name — the raw component name, resolved to
 * its Model the way every other `$ref` is. An inline branch has none, so one
 * is synthesised the same way {@see RequestUnionPlanner} names an inline
 * request-body branch: `<base>` plus the branch's own `title`, or `BranchN`.
 * Unlike the request side, an inline branch with *no* declared properties is
 * still nameable here — GitHub's `interactions/get-restrictions-for-*`
 * anyOf a `$ref` against exactly that shape (`{properties: {},
 * additionalProperties: false}`), and refusing it would refuse three
 * operations over a branch {@see BranchSelectors} already knows how to
 * decide by the *absence* of fields.
 *
 * Split from {@see ResponseUnionPlanner} to keep both under the linecop
 * limit (`quality-gates-at-maximum-strictness`).
 *
 * @internal
 */
final readonly class ResponseUnionBranches
{
    /**
     * @param  list<Schema|Reference>                     $branches
     * @param list<SynthesisedModel> $roots
     * @return array{0:array<int,string>,1:array<string,string>}|null identities parallel to `$branches`,
     *              and identity => PHP model name; null when a branch cannot be named, with `$refusal` set
     */
    public static function name(
        array $branches,
        string $base,
        string $status,
        string $rawId,
        NameRegistry $registry,
        ModelNameLedger $ledger,
        array &$roots,
        ?string &$refusal,
    ): ?array {
        $identities = [];
        $models = [];
        $index = 0;

        foreach ($branches as $branch) {
            ++$index;

            if ($branch instanceof Reference) {
                $raw = ComponentName::rawFromRef($branch->getReference());
                $identities[] = $raw;
                $models[$raw] = ComponentName::phpFromRef($branch->getReference(), $registry);

                continue;
            }

            if (!ObjectShape::is($branch)) {
                $refusal = sprintf(
                    '%s response of `%s` branch %d at %s is %s — poagen can only union branches it can express as '
                        . 'a PHP class (a $ref to a component, or an inline object); reduce this branch to one of '
                        . 'those, or skip the operation',
                    $status,
                    $rawId,
                    $index,
                    AllOfMerger::siteOf($branch),
                    self::describeUnnameable($branch),
                );

                return null;
            }

            $name = InlinePayloadPlanner::claim($base . 'Response' . self::branchLabel($branch, $index), $branch, $ledger, $roots);
            $identities[] = $name;
            $models[$name] = $name;
        }

        return [$identities, $models];
    }

    /**
     * @param  list<Schema|Reference> $branches
     * @param  array<int,string>      $identities parallel to `$branches`
     * @return array<string, EffectiveShape|null>
     */
    public static function shapesOf(array $branches, array $identities, OpenApi $openApi): array
    {
        $shapes = [];

        foreach ($branches as $i => $branch) {
            $identity = $identities[$i];
            $resolved = $branch instanceof Reference ? EffectiveShape::resolve($branch, $openApi) : $branch;
            $shapes[$identity] = $resolved instanceof Schema ? EffectiveShape::of($resolved, $openApi) : null;
        }

        return $shapes;
    }

    /**
     * Every branch's identity with no side effect — no ledger claim, no
     * registry lookup — for {@see UnionGuidanceValidator},
     * which only ever compares a `Profile::$unionPins`/`$unionTags` entry's
     * branch name against this list and never emits anything from it.
     * Reading an operation's response union twice (once here, once for
     * real by {@see name()}) is cheaper than threading the validator's own
     * throwaway ledger through a second code path for the same answer.
     *
     * @param  list<Schema|Reference> $branches
     * @return list<string>
     */
    public static function identities(array $branches, string $base): array
    {
        $identities = [];
        $index = 0;

        foreach ($branches as $branch) {
            ++$index;
            $identities[] = $branch instanceof Reference
                ? ComponentName::rawFromRef($branch->getReference())
                : $base . 'Response' . self::branchLabel($branch, $index);
        }

        return $identities;
    }

    /**
     * {@see identities()}, but reading the array-of-item-shapes case
     * ({@see ResponseArrayUnionPlanner}) the same way that class does —
     * the pinnable identity there is each item's raw component name, not
     * the array branch's.
     *
     * @param  list<Schema|Reference> $branches
     * @return list<string>
     */
    public static function branchIdentities(array $branches, string $base): array
    {
        $items = ResponseArrayUnionPlanner::itemRefs($branches);

        if ($items !== null) {
            return array_map(static fn(Reference $ref): string => ComponentName::rawFromRef($ref->getReference()), $items);
        }

        return self::identities($branches, $base);
    }

    /** A branch poagen cannot express as a PHP class: a bare `array`, or a scalar. */
    private static function describeUnnameable(Schema $branch): string
    {
        if (SchemaType::of($branch)->is('array')) {
            return 'a bare `array`, not a named class';
        }

        return 'a `type: ' . SchemaType::of($branch)->describe() . '` schema, not a named class';
    }

    /**
     * `<TitleOrIndex>` — mirrors {@see RequestUnionPlanner::branchLabel()} and
     * {@see AllOfBranchBuilder::branchLabel()}'s derivation, kept as its own
     * copy for the same reason those two already are: each caller closes
     * over a different naming context.
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
