<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhooksPreviousMarketplacePurchase
{
    /**
     * @param ?mixed $free_trial_ends_on
     */
    public function __construct(
        public WebhooksPreviousMarketplacePurchaseAccount $account,
        public string $billing_cycle,
        public $free_trial_ends_on = null,
        public bool $on_free_trial,
        public WebhooksPreviousMarketplacePurchasePlan $plan,
        public int $unit_count,
        public ?string $next_billing_date = null,
    ) {
    }
}
