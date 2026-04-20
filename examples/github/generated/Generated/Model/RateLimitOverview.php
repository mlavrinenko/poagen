<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RateLimitOverview
{
    public function __construct(
        public RateLimit $rate,
        public RateLimitOverviewResources $resources,
    ) {
    }
}
