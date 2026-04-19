<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class AccessKey implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'expires_at' => ['expires_at', ['datetime', null]],
        'id' => ['id', null],
        'name' => ['name', null],
        'updated_at' => ['updated_at', ['datetime', null]],
    ];

    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?DateTimeImmutable $expires_at = null,
        public ?string $id = null,
        public ?string $name = null,
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
            'expires_at' => $this->expires_at?->format(\DateTimeInterface::RFC3339),
            'id' => $this->id,
            'name' => $this->name,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
