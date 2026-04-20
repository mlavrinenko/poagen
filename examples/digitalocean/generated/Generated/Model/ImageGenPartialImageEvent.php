<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ImageGenPartialImageEvent
{
    public function __construct(
        public string $b64_json,
        public string $background,
        public int $created_at,
        public string $output_format,
        public int $partial_image_index,
        public string $quality,
        public string $size,
        public string $type,
    ) {
    }
}
