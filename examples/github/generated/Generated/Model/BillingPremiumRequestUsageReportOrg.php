<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class BillingPremiumRequestUsageReportOrg
{
    /**
     * @param list<array<string, mixed>> $usageItems
     */
    public function __construct(
        public string $organization,
        public BillingPremiumRequestUsageReportOrgTimePeriod $timePeriod,
        public array $usageItems,
        public ?string $model = null,
        public ?string $product = null,
        public ?string $user = null,
    ) {
    }
}
