<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class NfsActionsResponseAction implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'region_slug' => ['region_slug', null],
        'resource_id' => ['resource_id', null],
        'resource_type' => ['resource_type', null],
        'started_at' => ['started_at', ['datetime', null]],
        'status' => ['status', null],
        'type' => ['type', null],
    ];

    public function __construct(
        public string $region_slug,
        public string $resource_id,
        public string $resource_type,
        public DateTimeImmutable $started_at,
        public string $status,
        public string $type,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'region_slug' => $this->region_slug,
            'resource_id' => $this->resource_id,
            'resource_type' => $this->resource_type,
            'started_at' => $this->started_at->format(\DateTimeInterface::RFC3339),
            'status' => $this->status,
            'type' => $this->type,
        ];
    }
}
