<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class AddonsPlan implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'active' => ['active', null],
        'app_id' => ['app_id', null],
        'available' => ['available', null],
        'by_default' => ['by_default', null],
        'created_at' => ['created_at', ['datetime', null]],
        'display_name' => ['display_name', null],
        'id' => ['id', null],
        'price_per_month' => ['price_per_month', null],
        'slug' => ['slug', null],
        'state' => ['state', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'uuid' => ['uuid', null],
        'description' => ['description', null],
        'dimensions' => ['dimensions', ['list', \Acme\DigitalOcean\Generated\Model\AddonsDimensionWithPrice::class]],
        'features' => ['features', ['list', \Acme\DigitalOcean\Generated\Model\AddonsFeature::class]],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AddonsDimensionWithPrice> $dimensions
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AddonsFeature> $features
     */
    public function __construct(
        public bool $active,
        public int $app_id,
        public bool $available,
        public bool $by_default,
        public DateTimeImmutable $created_at,
        public string $display_name,
        public int $id,
        public int $price_per_month,
        public string $slug,
        public string $state,
        public DateTimeImmutable $updated_at,
        public string $uuid,
        public ?string $description = null,
        public ?array $dimensions = null,
        public ?array $features = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'active' => $this->active,
            'app_id' => $this->app_id,
            'available' => $this->available,
            'by_default' => $this->by_default,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'display_name' => $this->display_name,
            'id' => $this->id,
            'price_per_month' => $this->price_per_month,
            'slug' => $this->slug,
            'state' => $this->state,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'uuid' => $this->uuid,
            'description' => $this->description,
            'dimensions' => $this->dimensions,
            'features' => $this->features,
        ];
    }
}
