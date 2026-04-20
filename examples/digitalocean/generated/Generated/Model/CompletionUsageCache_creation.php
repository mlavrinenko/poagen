<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class CompletionUsageCache_creation
{
    public function __construct(
        public int $ephemeral_1h_input_tokens,
        public int $ephemeral_5m_input_tokens,
    ) {
    }
}
