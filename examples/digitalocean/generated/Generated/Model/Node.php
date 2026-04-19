<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Node implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'droplet_id' => ['droplet_id', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'status' => ['status', \Acme\DigitalOcean\Generated\Model\NodeStatus::class],
        'updated_at' => ['updated_at', ['datetime', null]],
    ];

    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $droplet_id = null,
        public ?string $id = null,
        public ?string $name = null,
        public ?NodeStatus $status = null,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'droplet_id' => $this->droplet_id,
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
