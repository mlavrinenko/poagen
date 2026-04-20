<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class BillingUsageSummaryReportOrg
{
    /**
     * @param list<array<string, mixed>> $usageItems
     */
    public function __construct(
        public string $organization,
        public BillingUsageSummaryReportOrgTimePeriod $timePeriod,
        public array $usageItems,
        public ?string $product = null,
        public ?string $repository = null,
        public ?string $sku = null,
    ) {
    }
}
