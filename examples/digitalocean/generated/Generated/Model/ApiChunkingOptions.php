<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiChunkingOptions implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'child_chunk_size' => ['child_chunk_size', null],
        'max_chunk_size' => ['max_chunk_size', null],
        'parent_chunk_size' => ['parent_chunk_size', null],
        'semantic_threshold' => ['semantic_threshold', null],
    ];

    public function __construct(
        public ?int $child_chunk_size = null,
        public ?int $max_chunk_size = null,
        public ?int $parent_chunk_size = null,
        public ?float $semantic_threshold = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'child_chunk_size' => $this->child_chunk_size,
            'max_chunk_size' => $this->max_chunk_size,
            'parent_chunk_size' => $this->parent_chunk_size,
            'semantic_threshold' => $this->semantic_threshold,
        ];
    }
}
