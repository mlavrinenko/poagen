<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class IssueType implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'description' => ['description', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'color' => ['color', null],
        'created_at' => ['created_at', ['datetime', null]],
        'is_enabled' => ['is_enabled', null],
        'updated_at' => ['updated_at', ['datetime', null]],
    ];

    public function __construct(
        public ?string $description = null,
        public int $id,
        public string $name,
        public string $node_id,
        public ?string $color = null,
        public ?DateTimeImmutable $created_at = null,
        public ?bool $is_enabled = null,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'id' => $this->id,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'color' => $this->color,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'is_enabled' => $this->is_enabled,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
