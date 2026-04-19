<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class DiscussionCategory implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'description' => ['description', null],
        'emoji' => ['emoji', null],
        'id' => ['id', null],
        'is_answerable' => ['is_answerable', null],
        'name' => ['name', null],
        'repository_id' => ['repository_id', null],
        'slug' => ['slug', null],
        'updated_at' => ['updated_at', null],
        'node_id' => ['node_id', null],
    ];

    public function __construct(
        public DateTimeImmutable $created_at,
        public string $description,
        public string $emoji,
        public int $id,
        public bool $is_answerable,
        public string $name,
        public int $repository_id,
        public string $slug,
        public string $updated_at,
        public ?string $node_id = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'description' => $this->description,
            'emoji' => $this->emoji,
            'id' => $this->id,
            'is_answerable' => $this->is_answerable,
            'name' => $this->name,
            'repository_id' => $this->repository_id,
            'slug' => $this->slug,
            'updated_at' => $this->updated_at,
            'node_id' => $this->node_id,
        ];
    }
}
