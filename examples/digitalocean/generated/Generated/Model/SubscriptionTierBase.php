<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class SubscriptionTierBase implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'allow_storage_overage' => ['allow_storage_overage', null],
        'included_bandwidth_bytes' => ['included_bandwidth_bytes', null],
        'included_repositories' => ['included_repositories', null],
        'included_storage_bytes' => ['included_storage_bytes', null],
        'monthly_price_in_cents' => ['monthly_price_in_cents', null],
        'name' => ['name', null],
        'slug' => ['slug', null],
        'storage_overage_price_in_cents' => ['storage_overage_price_in_cents', null],
    ];

    public function __construct(
        public ?bool $allow_storage_overage = null,
        public ?int $included_bandwidth_bytes = null,
        public ?int $included_repositories = null,
        public ?int $included_storage_bytes = null,
        public ?int $monthly_price_in_cents = null,
        public ?string $name = null,
        public ?string $slug = null,
        public ?int $storage_overage_price_in_cents = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'allow_storage_overage' => $this->allow_storage_overage,
            'included_bandwidth_bytes' => $this->included_bandwidth_bytes,
            'included_repositories' => $this->included_repositories,
            'included_storage_bytes' => $this->included_storage_bytes,
            'monthly_price_in_cents' => $this->monthly_price_in_cents,
            'name' => $this->name,
            'slug' => $this->slug,
            'storage_overage_price_in_cents' => $this->storage_overage_price_in_cents,
        ];
    }
}
