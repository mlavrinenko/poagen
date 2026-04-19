<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class IssueField implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'data_type' => ['data_type', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'created_at' => ['created_at', ['datetime', null]],
        'description' => ['description', null],
        'options' => ['options', ['list', null]],
        'updated_at' => ['updated_at', ['datetime', null]],
        'visibility' => ['visibility', null],
    ];

    /**
     * @param ?list<array<string, mixed>> $options
     */
    public function __construct(
        public string $data_type,
        public int $id,
        public string $name,
        public string $node_id,
        public ?DateTimeImmutable $created_at = null,
        public ?string $description = null,
        public ?array $options = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $visibility = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'data_type' => $this->data_type,
            'id' => $this->id,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'description' => $this->description,
            'options' => $this->options,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'visibility' => $this->visibility,
        ];
    }
}
