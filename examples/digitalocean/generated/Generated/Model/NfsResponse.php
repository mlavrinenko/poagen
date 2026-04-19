<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class NfsResponse implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'id' => ['id', null],
        'name' => ['name', null],
        'region' => ['region', null],
        'size_gib' => ['size_gib', null],
        'status' => ['status', null],
        'host' => ['host', null],
        'mount_path' => ['mount_path', null],
        'vpc_ids' => ['vpc_ids', ['list', null]],
    ];

    /**
     * @param ?list<string> $vpc_ids
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public string $id,
        public string $name,
        public string $region,
        public int $size_gib,
        public string $status,
        public ?string $host = null,
        public ?string $mount_path = null,
        public ?array $vpc_ids = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'id' => $this->id,
            'name' => $this->name,
            'region' => $this->region,
            'size_gib' => $this->size_gib,
            'status' => $this->status,
            'host' => $this->host,
            'mount_path' => $this->mount_path,
            'vpc_ids' => $this->vpc_ids,
        ];
    }
}
