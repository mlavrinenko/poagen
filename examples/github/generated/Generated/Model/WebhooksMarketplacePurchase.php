<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhooksMarketplacePurchase
{
    public function __construct(
        public WebhooksMarketplacePurchaseAccount $account,
        public string $billing_cycle,
        public ?string $free_trial_ends_on = null,
        public ?string $next_billing_date = null,
        public bool $on_free_trial,
        public WebhooksMarketplacePurchasePlan $plan,
        public int $unit_count,
    ) {
    }
}
