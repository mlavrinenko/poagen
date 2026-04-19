<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Workflow implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'badge_url' => ['badge_url', null],
        'created_at' => ['created_at', ['datetime', null]],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'path' => ['path', null],
        'state' => ['state', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'deleted_at' => ['deleted_at', ['datetime', null]],
    ];

    public function __construct(
        public string $badge_url,
        public DateTimeImmutable $created_at,
        public string $html_url,
        public int $id,
        public string $name,
        public string $node_id,
        public string $path,
        public string $state,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?DateTimeImmutable $deleted_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'badge_url' => $this->badge_url,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'html_url' => $this->html_url,
            'id' => $this->id,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'path' => $this->path,
            'state' => $this->state,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'deleted_at' => $this->deleted_at?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
