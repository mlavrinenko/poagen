<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Enum\EnumCatalog;

use function is_array;
use function is_string;
use function sprintf;

/**
 * Turns the one `oneOf`/`anyOf` member {@see AllOfMerger} found into a list
 * of {@see AllOfBranch} — one per branch, each the full merged shape the
 * rest of the `allOf` already accumulated, plus that branch's own
 * `properties`/`required`.
 *
 * Split from {@see AllOfMerger} to keep both under the linecop limit.
 *
 * @internal
 */
final readonly class AllOfBranchBuilder
{
    /**
     * @return list<AllOfBranch>
     */
    public static function build(AllOfAccumulator $acc): array
    {
        $union = $acc->unionMember ?? throw new AllOfRefusal('allOf union member missing — this should not happen');
        $branches = [];
        $index = 0;

        foreach (AllOfMerger::rawBranches($union) as $branch) {
            ++$index;
            $branches[] = self::branchFrom($branch, $index, $acc);
        }

        return $branches;
    }

    private static function branchFrom(Schema|Reference $branch, int $index, AllOfAccumulator $acc): AllOfBranch
    {
        if (!$branch instanceof Schema) {
            throw new AllOfRefusal(sprintf(
                'allOf member %s branch %d is a $ref, not an inline object shape — paogen only merges inline '
                    . 'property/required branches',
                $acc->unionSite,
                $index,
            ));
        }

        if (AllOfMerger::rawBranches($branch) !== [] || (is_array($branch->allOf) && $branch->allOf !== [])) {
            throw new AllOfRefusal(sprintf(
                'allOf member %s branch %d nests further composition — paogen does not model that depth',
                $acc->unionSite,
                $index,
            ));
        }

        $branchAcc = clone $acc;
        $branchSite = AllOfMerger::siteOf($branch);
        AllOfMerger::foldProperties($branchAcc, $branch->properties ?? [], $branchSite);
        AllOfMerger::foldRequired($branchAcc, $branch->required ?? []);
        AllOfMerger::assertRequiredDeclared($branchAcc->required, $branchAcc->properties, $branchAcc->memberSites);

        return new AllOfBranch(
            self::branchLabel($branch, $index),
            AllOfMerger::schemaFrom($branchAcc->properties, $branchAcc->required),
            $branchSite,
        );
    }

    /**
     * `<TitleOrIndex>` — mirrors `ModelPlanner::branchLabel()`'s derivation
     * for a top-level component union's inline branch, so a title-bearing
     * `anyOf` branch inside an `allOf` names itself the same way one does
     * anywhere else in the generator.
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
