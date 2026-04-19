<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class DeployKey implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', null],
        'id' => ['id', null],
        'key' => ['key', null],
        'read_only' => ['read_only', null],
        'title' => ['title', null],
        'url' => ['url', null],
        'verified' => ['verified', null],
        'added_by' => ['added_by', null],
        'enabled' => ['enabled', null],
        'last_used' => ['last_used', ['datetime', null]],
    ];

    public function __construct(
        public string $created_at,
        public int $id,
        public string $key,
        public bool $read_only,
        public string $title,
        public string $url,
        public bool $verified,
        public ?string $added_by = null,
        public ?bool $enabled = null,
        public ?DateTimeImmutable $last_used = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at,
            'id' => $this->id,
            'key' => $this->key,
            'read_only' => $this->read_only,
            'title' => $this->title,
            'url' => $this->url,
            'verified' => $this->verified,
            'added_by' => $this->added_by,
            'enabled' => $this->enabled,
            'last_used' => $this->last_used?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
