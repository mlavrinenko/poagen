<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiPromptChunk
{
    public function __construct(
        public ?float $chunk_usage_pct = null,
        public ?bool $chunk_used = null,
        public ?string $index_uuid = null,
        public ?string $source_name = null,
        public ?string $text = null,
    ) {
    }
}
