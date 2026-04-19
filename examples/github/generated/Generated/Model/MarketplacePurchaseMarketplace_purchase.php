<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class MarketplacePurchaseMarketplace_purchase implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'billing_cycle' => ['billing_cycle', null],
        'free_trial_ends_on' => ['free_trial_ends_on', null],
        'is_installed' => ['is_installed', null],
        'next_billing_date' => ['next_billing_date', null],
        'on_free_trial' => ['on_free_trial', null],
        'plan' => ['plan', \Acme\GitHub\Generated\Model\MarketplaceListingPlan::class],
        'unit_count' => ['unit_count', null],
        'updated_at' => ['updated_at', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'billing_cycle' => $this->billing_cycle,
            'free_trial_ends_on' => $this->free_trial_ends_on,
            'is_installed' => $this->is_installed,
            'next_billing_date' => $this->next_billing_date,
            'on_free_trial' => $this->on_free_trial,
            'plan' => $this->plan,
            'unit_count' => $this->unit_count,
            'updated_at' => $this->updated_at,
        ];
    }
}
