<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookMarketplacePurchasePendingChangePrevious_marketplace_purchase
{
    public function __construct(
        public WebhookMarketplacePurchasePendingChangePrevious_marketplace_purchaseAccount $account,
        public string $billing_cycle,
        public ?string $free_trial_ends_on = null,
        public bool $on_free_trial,
        public WebhookMarketplacePurchasePendingChangePrevious_marketplace_purchasePlan $plan,
        public int $unit_count,
        public ?string $next_billing_date = null,
    ) {
    }
}
