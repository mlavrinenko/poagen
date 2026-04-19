<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiPromptChunk implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'chunk_usage_pct' => ['chunk_usage_pct', null],
        'chunk_used' => ['chunk_used', null],
        'index_uuid' => ['index_uuid', null],
        'source_name' => ['source_name', null],
        'text' => ['text', null],
    ];

    public function __construct(
        public ?float $chunk_usage_pct = null,
        public ?bool $chunk_used = null,
        public ?string $index_uuid = null,
        public ?string $source_name = null,
        public ?string $text = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'chunk_usage_pct' => $this->chunk_usage_pct,
            'chunk_used' => $this->chunk_used,
            'index_uuid' => $this->index_uuid,
            'source_name' => $this->source_name,
            'text' => $this->text,
        ];
    }
}
