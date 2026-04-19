<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Action implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'completed_at' => ['completed_at', ['datetime', null]],
        'id' => ['id', null],
        'region' => ['region', \Acme\DigitalOcean\Generated\Model\Region::class],
        'region_slug' => ['region_slug', null],
        'resource_id' => ['resource_id', null],
        'resource_type' => ['resource_type', null],
        'started_at' => ['started_at', ['datetime', null]],
        'status' => ['status', null],
        'type' => ['type', null],
    ];

    public function __construct(
        public ?DateTimeImmutable $completed_at = null,
        public ?int $id = null,
        public ?Region $region = null,
        public ?string $region_slug = null,
        public ?int $resource_id = null,
        public ?string $resource_type = null,
        public ?DateTimeImmutable $started_at = null,
        public ?string $status = null,
        public ?string $type = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'completed_at' => $this->completed_at?->format(\DateTimeInterface::RFC3339),
            'id' => $this->id,
            'region' => $this->region,
            'region_slug' => $this->region_slug,
            'resource_id' => $this->resource_id,
            'resource_type' => $this->resource_type,
            'started_at' => $this->started_at?->format(\DateTimeInterface::RFC3339),
            'status' => $this->status,
            'type' => $this->type,
        ];
    }
}
