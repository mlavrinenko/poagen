<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class MultiregistryCreate implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'name' => ['name', null],
        'region' => ['region', null],
        'subscription_tier_slug' => ['subscription_tier_slug', null],
    ];

    public function __construct(
        public string $name,
        public ?string $region = null,
        public ?string $subscription_tier_slug = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'region' => $this->region,
            'subscription_tier_slug' => $this->subscription_tier_slug,
        ];
    }
}
