<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiChunkingOptions
{
    public function __construct(
        public ?int $child_chunk_size = null,
        public ?int $max_chunk_size = null,
        public ?int $parent_chunk_size = null,
        public ?float $semantic_threshold = null,
    ) {
    }
}
