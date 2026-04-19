<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Key implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'id' => ['id', null],
        'key' => ['key', null],
        'read_only' => ['read_only', null],
        'title' => ['title', null],
        'url' => ['url', null],
        'verified' => ['verified', null],
        'last_used' => ['last_used', ['datetime', null]],
    ];

    public function __construct(
        public DateTimeImmutable $created_at,
        public int $id,
        public string $key,
        public bool $read_only,
        public string $title,
        public string $url,
        public bool $verified,
        public ?DateTimeImmutable $last_used = null,
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
            'key' => $this->key,
            'read_only' => $this->read_only,
            'title' => $this->title,
            'url' => $this->url,
            'verified' => $this->verified,
            'last_used' => $this->last_used?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
