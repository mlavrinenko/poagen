<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class GarbageCollection implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'blobs_deleted' => ['blobs_deleted', null],
        'created_at' => ['created_at', ['datetime', null]],
        'freed_bytes' => ['freed_bytes', null],
        'registry_name' => ['registry_name', null],
        'status' => ['status', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'uuid' => ['uuid', null],
    ];

    public function __construct(
        public ?int $blobs_deleted = null,
        public ?DateTimeImmutable $created_at = null,
        public ?int $freed_bytes = null,
        public ?string $registry_name = null,
        public ?string $status = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'blobs_deleted' => $this->blobs_deleted,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'freed_bytes' => $this->freed_bytes,
            'registry_name' => $this->registry_name,
            'status' => $this->status,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'uuid' => $this->uuid,
        ];
    }
}
