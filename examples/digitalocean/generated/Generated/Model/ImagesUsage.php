<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ImagesUsage
{
    public function __construct(
        public int $input_tokens,
        public ImagesUsageInput_tokens_details $input_tokens_details,
        public int $output_tokens,
        public int $total_tokens,
    ) {
    }
}
