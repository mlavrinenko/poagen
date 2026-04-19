<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class MarketplaceListingPlan implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'accounts_url' => ['accounts_url', null],
        'bullets' => ['bullets', ['list', null]],
        'description' => ['description', null],
        'has_free_trial' => ['has_free_trial', null],
        'id' => ['id', null],
        'monthly_price_in_cents' => ['monthly_price_in_cents', null],
        'name' => ['name', null],
        'number' => ['number', null],
        'price_model' => ['price_model', null],
        'state' => ['state', null],
        'unit_name' => ['unit_name', null],
        'url' => ['url', null],
        'yearly_price_in_cents' => ['yearly_price_in_cents', null],
    ];

    /**
     * @param list<string> $bullets
     */
    public function __construct(
        public string $accounts_url,
        public array $bullets,
        public string $description,
        public bool $has_free_trial,
        public int $id,
        public int $monthly_price_in_cents,
        public string $name,
        public int $number,
        public string $price_model,
        public string $state,
        public ?string $unit_name = null,
        public string $url,
        public int $yearly_price_in_cents,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'accounts_url' => $this->accounts_url,
            'bullets' => $this->bullets,
            'description' => $this->description,
            'has_free_trial' => $this->has_free_trial,
            'id' => $this->id,
            'monthly_price_in_cents' => $this->monthly_price_in_cents,
            'name' => $this->name,
            'number' => $this->number,
            'price_model' => $this->price_model,
            'state' => $this->state,
            'unit_name' => $this->unit_name,
            'url' => $this->url,
            'yearly_price_in_cents' => $this->yearly_price_in_cents,
        ];
    }
}
