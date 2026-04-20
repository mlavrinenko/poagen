<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class CompletionUsage
{
    public function __construct(
        public int $cache_created_input_tokens,
        public CompletionUsageCache_creation $cache_creation,
        public int $cache_read_input_tokens,
        public int $completion_tokens,
        public int $prompt_tokens,
        public int $total_tokens,
    ) {
    }
}
