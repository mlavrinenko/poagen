<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class BillingPremiumRequestUsageReportUserTimePeriod
{
    public function __construct(
        public int $year,
        public ?int $day = null,
        public ?int $month = null,
    ) {
    }
}
