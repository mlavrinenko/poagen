<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class KeySimple implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'id' => ['id', null],
        'key' => ['key', null],
        'created_at' => ['created_at', ['datetime', null]],
        'last_used' => ['last_used', ['datetime', null]],
    ];

    public function __construct(
        public int $id,
        public string $key,
        public ?DateTimeImmutable $created_at = null,
        public ?DateTimeImmutable $last_used = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'key' => $this->key,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'last_used' => $this->last_used?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
