<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Schema;

/**
 * The one call every `InlinePayloadPlanner::claim($pin ?? <derived name>, ...)`
 * site used to make directly, now routed through here so a pin is recognised
 * as a possible merge wherever it can appear rather than only where a caller
 * remembered to ask for it.
 *
 * {@see InlinePayloadPlanner::claim()} when `$pin` is null — an auto-derived
 * name never merges (nothing-merges-on-its-own) — or the merge-aware claim
 * below when it is not, because an explicit `Profile::$inlineModels` entry
 * may legitimately name one class from several sites
 * (name-inline-schemas-by-operation-and-status).
 *
 * Split out of {@see InlinePayloadPlanner} to keep both under the linecop
 * limit.
 *
 * @internal
 */
final readonly class InlineModelClaim
{
    /**
     * @param list<SynthesisedModel> $roots
     */
    public static function named(?string $pin, string $derived, Schema $schema, ModelNameLedger $ledger, array &$roots, ?string $origin = null): string
    {
        return $pin !== null
            ? self::pinned($pin, $schema, $ledger, $roots, $origin)
            : InlinePayloadPlanner::claim($derived, $schema, $ledger, $roots, $origin);
    }

    /**
     * The first site naming a given pin emits the class; every later one
     * naming the same pin reuses it rather than emitting a second file —
     * safe because {@see InlineModelMergeValidator} has already proven every
     * site in the group emits the identical shape.
     *
     * @param list<SynthesisedModel> $roots
     */
    public static function pinned(string $name, Schema $schema, ModelNameLedger $ledger, array &$roots, ?string $origin = null): string
    {
        $origin ??= SynthesisedModel::originOf($schema);

        if ($ledger->claimMerge($name, $origin)) {
            $roots[] = new SynthesisedModel($name, $schema, [], $origin);
        }

        return $name;
    }
}
