<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class DatabaseReplica implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'name' => ['name', null],
        'connection' => ['connection', null],
        'created_at' => ['created_at', ['datetime', null]],
        'do_settings' => ['do_settings', null],
        'id' => ['id', null],
        'private_connection' => ['private_connection', null],
        'private_network_uuid' => ['private_network_uuid', null],
        'region' => ['region', null],
        'size' => ['size', null],
        'status' => ['status', null],
        'storage_size_mib' => ['storage_size_mib', null],
        'tags' => ['tags', ['list', null]],
    ];

    /**
     * @param ?mixed $connection
     * @param ?mixed $do_settings
     * @param ?mixed $private_connection
     * @param ?list<string> $tags
     */
    public function __construct(
        public string $name,
        public $connection = null,
        public ?DateTimeImmutable $created_at = null,
        public $do_settings = null,
        public ?string $id = null,
        public $private_connection = null,
        public ?string $private_network_uuid = null,
        public ?string $region = null,
        public ?string $size = null,
        public ?string $status = null,
        public ?int $storage_size_mib = null,
        public ?array $tags = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'connection' => $this->connection,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'do_settings' => $this->do_settings,
            'id' => $this->id,
            'private_connection' => $this->private_connection,
            'private_network_uuid' => $this->private_network_uuid,
            'region' => $this->region,
            'size' => $this->size,
            'status' => $this->status,
            'storage_size_mib' => $this->storage_size_mib,
            'tags' => $this->tags,
        ];
    }
}
