<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Schema;

/**
 * One {@see InlineModelSiteWalk} result: a site paired with the schema it
 * would name a class from, and whether that site is the array-item variant
 * (`{Base}{Position}ContentItem` rather than `{Base}{Position}Content`) —
 * the one fact {@see InlineModelSiteResolver}'s own, simpler return type
 * throws away because a merge or a stale-pin check does not need it.
 *
 * @internal
 */
final readonly class InlineModelSiteSchema
{
    public function __construct(
        public InlineModelSite $site,
        public Schema $schema,
        public bool $item,
    ) {}
}
