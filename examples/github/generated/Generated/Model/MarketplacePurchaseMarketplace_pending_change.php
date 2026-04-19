<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class MarketplacePurchaseMarketplace_pending_change implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'effective_date' => ['effective_date', null],
        'id' => ['id', null],
        'is_installed' => ['is_installed', null],
        'plan' => ['plan', \Acme\GitHub\Generated\Model\MarketplaceListingPlan::class],
        'unit_count' => ['unit_count', null],
    ];

    public function __construct(
        public ?string $effective_date = null,
        public ?int $id = null,
        public ?bool $is_installed = null,
        public ?MarketplaceListingPlan $plan = null,
        public ?int $unit_count = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'effective_date' => $this->effective_date,
            'id' => $this->id,
            'is_installed' => $this->is_installed,
            'plan' => $this->plan,
            'unit_count' => $this->unit_count,
        ];
    }
}
