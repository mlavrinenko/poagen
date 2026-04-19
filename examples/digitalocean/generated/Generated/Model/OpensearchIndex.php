<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class OpensearchIndex implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_time' => ['created_time', ['datetime', null]],
        'health' => ['health', null],
        'index_name' => ['index_name', null],
        'number_of_replicas' => ['number_of_replicas', null],
        'number_of_shards' => ['number_of_shards', null],
        'size' => ['size', null],
        'status' => ['status', null],
    ];

    public function __construct(
        public ?DateTimeImmutable $created_time = null,
        public ?string $health = null,
        public ?string $index_name = null,
        public ?int $number_of_replicas = null,
        public ?int $number_of_shards = null,
        public ?int $size = null,
        public ?string $status = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_time' => $this->created_time?->format(\DateTimeInterface::RFC3339),
            'health' => $this->health,
            'index_name' => $this->index_name,
            'number_of_replicas' => $this->number_of_replicas,
            'number_of_shards' => $this->number_of_shards,
            'size' => $this->size,
            'status' => $this->status,
        ];
    }
}
