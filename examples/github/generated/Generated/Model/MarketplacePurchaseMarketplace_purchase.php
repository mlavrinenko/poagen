<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class MarketplacePurchaseMarketplace_purchase
{
    public function __construct(
        public ?string $billing_cycle = null,
        public ?string $free_trial_ends_on = null,
        public ?bool $is_installed = null,
        public ?string $next_billing_date = null,
        public ?bool $on_free_trial = null,
        public ?MarketplaceListingPlan $plan = null,
        public ?int $unit_count = null,
        public ?string $updated_at = null,
    ) {
    }
}
