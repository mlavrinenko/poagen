<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class UserMarketplacePurchase implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'account' => ['account', \Acme\GitHub\Generated\Model\MarketplaceAccount::class],
        'billing_cycle' => ['billing_cycle', null],
        'free_trial_ends_on' => ['free_trial_ends_on', ['datetime', null]],
        'next_billing_date' => ['next_billing_date', ['datetime', null]],
        'on_free_trial' => ['on_free_trial', null],
        'plan' => ['plan', \Acme\GitHub\Generated\Model\MarketplaceListingPlan::class],
        'unit_count' => ['unit_count', null],
        'updated_at' => ['updated_at', ['datetime', null]],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'account' => $this->account,
            'billing_cycle' => $this->billing_cycle,
            'free_trial_ends_on' => $this->free_trial_ends_on?->format(\DateTimeInterface::RFC3339),
            'next_billing_date' => $this->next_billing_date?->format(\DateTimeInterface::RFC3339),
            'on_free_trial' => $this->on_free_trial,
            'plan' => $this->plan,
            'unit_count' => $this->unit_count,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
