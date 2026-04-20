<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ApiInsightsSummaryStats
{
    public function __construct(
        public ?int $rate_limited_request_count = null,
        public ?int $total_request_count = null,
    ) {
    }
}
