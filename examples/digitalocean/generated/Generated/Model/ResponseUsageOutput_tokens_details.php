<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ResponseUsageOutput_tokens_details
{
    public function __construct(
        public int $reasoning_tokens,
        public int $tool_output_tokens,
    ) {
    }
}
