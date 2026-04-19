<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookMarketplacePurchaseChangedPrevious_marketplace_purchase implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'account' => [
            'account',
            \Acme\GitHub\Generated\Model\WebhookMarketplacePurchaseChangedPrevious_marketplace_purchaseAccount::class,
        ],
        'billing_cycle' => ['billing_cycle', null],
        'free_trial_ends_on' => ['free_trial_ends_on', null],
        'on_free_trial' => ['on_free_trial', null],
        'plan' => [
            'plan',
            \Acme\GitHub\Generated\Model\WebhookMarketplacePurchaseChangedPrevious_marketplace_purchasePlan::class,
        ],
        'unit_count' => ['unit_count', null],
        'next_billing_date' => ['next_billing_date', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'account' => $this->account,
            'billing_cycle' => $this->billing_cycle,
            'free_trial_ends_on' => $this->free_trial_ends_on,
            'on_free_trial' => $this->on_free_trial,
            'plan' => $this->plan,
            'unit_count' => $this->unit_count,
            'next_billing_date' => $this->next_billing_date,
        ];
    }
}
