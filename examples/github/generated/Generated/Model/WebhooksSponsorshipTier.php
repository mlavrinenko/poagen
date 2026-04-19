<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhooksSponsorshipTier implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', null],
        'description' => ['description', null],
        'is_one_time' => ['is_one_time', null],
        'monthly_price_in_cents' => ['monthly_price_in_cents', null],
        'monthly_price_in_dollars' => ['monthly_price_in_dollars', null],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'is_custom_ammount' => ['is_custom_ammount', null],
        'is_custom_amount' => ['is_custom_amount', null],
    ];

    public function __construct(
        public string $created_at,
        public string $description,
        public bool $is_one_time,
        public int $monthly_price_in_cents,
        public int $monthly_price_in_dollars,
        public string $name,
        public string $node_id,
        public ?bool $is_custom_ammount = null,
        public ?bool $is_custom_amount = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at,
            'description' => $this->description,
            'is_one_time' => $this->is_one_time,
            'monthly_price_in_cents' => $this->monthly_price_in_cents,
            'monthly_price_in_dollars' => $this->monthly_price_in_dollars,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'is_custom_ammount' => $this->is_custom_ammount,
            'is_custom_amount' => $this->is_custom_amount,
        ];
    }
}
