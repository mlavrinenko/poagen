<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class VpcPeering implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'id' => ['id', null],
        'name' => ['name', null],
        'status' => ['status', null],
        'vpc_ids' => ['vpc_ids', ['list', null]],
    ];

    /**
     * @param ?list<string> $vpc_ids
     */
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $id = null,
        public ?string $name = null,
        public ?string $status = null,
        public ?array $vpc_ids = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'vpc_ids' => $this->vpc_ids,
        ];
    }
}
