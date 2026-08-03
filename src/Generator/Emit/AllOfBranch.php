<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Schema;

/**
 * One branch of a `oneOf`/`anyOf` member found inside an `allOf` list.
 *
 * {@see AllOfMerger} produces one of these per branch when exactly one
 * `allOf` member is a union: {@see $schema} is the branch's *full* merged
 * shape — every property/required name the rest of the `allOf` already
 * found, plus this branch's own — so each branch stands alone as a
 * synthesisable model. {@see InlinePayloadPlanner} turns each branch into a
 * named class and joins them into the PHP union the body parameter (or
 * return type) declares.
 *
 * @internal
 */
final readonly class AllOfBranch
{
    /**
     * @param string $label  the `<TitleOrIndex>` suffix — a pascalized
     *                       `title`, or `Branch<n>` when the branch declared
     *                       none — appended to the operation's base name to
     *                       form the class name, mirroring
     *                       `ModelPlanner::branchLabel()`'s derivation for a
     *                       top-level component union's inline branch
     * @param Schema $schema the branch's full merged shape
     * @param string $origin the raw branch node's document position, for a
     *                       {@see ModelNameLedger} collision diagnostic that
     *                       points at the document rather than at a
     *                       synthesised schema with no position of its own
     */
    public function __construct(
        public string $label,
        public Schema $schema,
        public string $origin,
    ) {}
}
