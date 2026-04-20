<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class UserMarketplacePurchase
{
    public function __construct(
        public MarketplaceAccount $account,
        public string $billing_cycle,
        public ?DateTimeImmutable $free_trial_ends_on = null,
        public ?DateTimeImmutable $next_billing_date = null,
        public bool $on_free_trial,
        public MarketplaceListingPlan $plan,
        public ?int $unit_count = null,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }
}
