<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ImagesUsageInput_tokens_details
{
    public function __construct(
        public int $image_tokens,
        public int $text_tokens,
    ) {
    }
}
