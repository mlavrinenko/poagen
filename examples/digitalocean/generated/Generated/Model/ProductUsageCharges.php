<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ProductUsageCharges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'amount' => ['amount', null],
        'items' => ['items', ['list', \Acme\DigitalOcean\Generated\Model\ProductChargeItem::class]],
        'name' => ['name', null],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ProductChargeItem> $items
     */
    public function __construct(
        public ?string $amount = null,
        public ?array $items = null,
        public ?string $name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'amount' => $this->amount,
            'items' => $this->items,
            'name' => $this->name,
        ];
    }
}
