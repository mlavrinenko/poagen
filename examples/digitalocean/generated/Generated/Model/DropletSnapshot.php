<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class DropletSnapshot implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'id' => ['id', null],
        'min_disk_size' => ['min_disk_size', null],
        'name' => ['name', null],
        'regions' => ['regions', ['list', null]],
        'size_gigabytes' => ['size_gigabytes', null],
        'type' => ['type', null],
    ];

    /**
     * @param list<string> $regions
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public int $id,
        public int $min_disk_size,
        public string $name,
        public array $regions,
        public float $size_gigabytes,
        public string $type,
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
            'min_disk_size' => $this->min_disk_size,
            'name' => $this->name,
            'regions' => $this->regions,
            'size_gigabytes' => $this->size_gigabytes,
            'type' => $this->type,
        ];
    }
}
