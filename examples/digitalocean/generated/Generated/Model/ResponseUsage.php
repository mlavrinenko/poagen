<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ResponseUsage
{
    public function __construct(
        public int $input_tokens,
        public ResponseUsageInput_tokens_details $input_tokens_details,
        public int $output_tokens,
        public ResponseUsageOutput_tokens_details $output_tokens_details,
        public int $total_tokens,
    ) {
    }
}
