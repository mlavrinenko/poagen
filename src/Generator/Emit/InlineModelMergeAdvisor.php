<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use Mlavrinenko\Paogen\Generator\Naming\InlinePayloadName;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Mlavrinenko\Paogen\Generator\Naming\NormalisationContext;
use Mlavrinenko\Paogen\Generator\Naming\SymbolKind;

use function array_filter;
use function array_map;
use function array_values;
use function count;
use function implode;
use function sprintf;
use function usort;

/**
 * Reports every group of structurally identical inline schemas the document
 * declares, and the exact `Profile::$inlineModels` block that would merge
 * them — the notice channel `report-unrecognised-formats` established:
 * stderr, informational, never moving the exit status
 * (name-inline-schemas-by-operation-and-status).
 *
 * kilbil is the corpus this exists for: all 36 operations declare a `403`
 * with the identical `{result_code, result_text}` body, which without a
 * merge becomes 36 near-identical classes. Nothing here merges anything —
 * {@see InlinePayloadPlanner} still names one class per site until a
 * consumer pastes the block this prints — it only makes the duplication and
 * the fix it wants visible.
 *
 * Groups by comparing each candidate site's schema against every group's
 * first member with {@see InlineShapeFingerprint::same()}, rather than
 * building a separate hashable canonical key: realistic corpora carry a few
 * hundred sites and a handful of distinct shapes, so the quadratic-looking
 * walk stays cheap, and it reuses the exact rule
 * {@see InlineModelMergeValidator} already checks a real merge against
 * instead of a second reading of "the same shape."
 *
 * @internal
 */
final readonly class InlineModelMergeAdvisor
{
    /**
     * @param array<string,string> $preScannedSkips raw operationId → reason, {@see InlineModelSiteWalk}
     * @return list<string>        one line per group of 2+ structurally identical inline schemas
     */
    public static function notices(OpenApi $openApi, NameRegistry $operationIdRegistry, array $preScannedSkips = []): array
    {
        $groups = array_values(array_filter(
            self::group(InlineModelSiteWalk::sites($openApi, $preScannedSkips)),
            static fn(array $group): bool => count($group) >= 2,
        ));

        usort($groups, static function (array $a, array $b): int {
            $byCount = count($b) <=> count($a);

            return $byCount !== 0 ? $byCount : $a[0]->site->key() <=> $b[0]->site->key();
        });

        return array_map(
            static fn(array $group): string => self::describe($group, $operationIdRegistry),
            $groups,
        );
    }

    /**
     * @param  list<InlineModelSiteSchema> $sites
     * @return list<list<InlineModelSiteSchema>>
     */
    private static function group(array $sites): array
    {
        $groups = [];

        foreach ($sites as $candidate) {
            $placed = false;

            foreach ($groups as $index => $group) {
                if (InlineShapeFingerprint::same($group[0]->schema, $candidate->schema)) {
                    $groups[$index][] = $candidate;
                    $placed = true;

                    break;
                }
            }

            if (!$placed) {
                $groups[] = [$candidate];
            }
        }

        return $groups;
    }

    /**
     * @param list<InlineModelSiteSchema> $group
     */
    private static function describe(array $group, NameRegistry $operationIdRegistry): string
    {
        $suggested = self::suggestedName($group[0], $operationIdRegistry);
        $lines = [sprintf(
            '%d structurally identical inline schemas — paste into Profile::$inlineModels to merge:',
            count($group),
        )];
        $lines[] = sprintf("    '%s' => [", $suggested);

        foreach ($group as $member) {
            $lines[] = sprintf("        '%s',", $member->site->key());
        }

        $lines[] = '    ],';

        return implode("\n", $lines);
    }

    private static function suggestedName(InlineModelSiteSchema $member, NameRegistry $operationIdRegistry): string
    {
        $base = ucfirst($operationIdRegistry->resolve($member->site->operationId, new NormalisationContext(SymbolKind::OperationId)));

        return $member->site->isRequest()
            ? InlinePayloadName::request($base, $member->item)
            : InlinePayloadName::response($base, $member->site->position, $member->item);
    }
}
