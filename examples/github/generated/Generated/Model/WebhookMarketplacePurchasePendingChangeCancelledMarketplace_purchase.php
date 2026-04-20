<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookMarketplacePurchasePendingChangeCancelledMarketplace_purchase
{
    /**
     * @param ?mixed $free_trial_ends_on
     */
    public function __construct(
        public WebhookMarketplacePurchasePendingChangeCancelledMarketplace_purchaseAccount $account,
        public string $billing_cycle,
        public $free_trial_ends_on = null,
        public ?string $next_billing_date = null,
        public bool $on_free_trial,
        public WebhookMarketplacePurchasePendingChangeCancelledMarketplace_purchasePlan $plan,
        public int $unit_count,
    ) {
    }
}
