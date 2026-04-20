<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CampaignSummaryAlert_stats
{
    public function __construct(
        public int $closed_count,
        public int $in_progress_count,
        public int $open_count,
    ) {
    }
}
