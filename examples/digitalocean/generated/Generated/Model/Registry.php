<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Registry implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'name' => ['name', null],
        'region' => ['region', null],
        'storage_usage_bytes' => ['storage_usage_bytes', null],
        'storage_usage_bytes_updated_at' => ['storage_usage_bytes_updated_at', ['datetime', null]],
        'subscription' => ['subscription', null],
    ];

    /**
     * @param ?mixed $subscription
     */
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $name = null,
        public ?string $region = null,
        public ?int $storage_usage_bytes = null,
        public ?DateTimeImmutable $storage_usage_bytes_updated_at = null,
        public $subscription = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'name' => $this->name,
            'region' => $this->region,
            'storage_usage_bytes' => $this->storage_usage_bytes,
            'storage_usage_bytes_updated_at' => $this->storage_usage_bytes_updated_at?->format(\DateTimeInterface::RFC3339),
            'subscription' => $this->subscription,
        ];
    }
}
