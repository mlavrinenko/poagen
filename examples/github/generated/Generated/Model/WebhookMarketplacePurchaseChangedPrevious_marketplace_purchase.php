<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookMarketplacePurchaseChangedPrevious_marketplace_purchase
{
    public function __construct(
        public WebhookMarketplacePurchaseChangedPrevious_marketplace_purchaseAccount $account,
        public string $billing_cycle,
        public ?string $free_trial_ends_on = null,
        public ?bool $on_free_trial = null,
        public WebhookMarketplacePurchaseChangedPrevious_marketplace_purchasePlan $plan,
        public int $unit_count,
        public ?string $next_billing_date = null,
    ) {
    }
}
