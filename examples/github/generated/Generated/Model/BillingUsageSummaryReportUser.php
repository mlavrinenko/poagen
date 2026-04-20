<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class BillingUsageSummaryReportUser
{
    /**
     * @param list<array<string, mixed>> $usageItems
     */
    public function __construct(
        public BillingUsageSummaryReportUserTimePeriod $timePeriod,
        public array $usageItems,
        public string $user,
        public ?string $product = null,
        public ?string $repository = null,
        public ?string $sku = null,
    ) {
    }
}
