<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class CreateImageRequest
{
    public function __construct(
        public string $model,
        public int $n,
        public string $prompt,
        public ?string $background = null,
        public ?string $moderation = null,
        public ?int $output_compression = null,
        public ?string $output_format = null,
        public ?int $partial_images = null,
        public ?string $quality = null,
        public ?string $size = null,
        public ?bool $stream = null,
        public ?string $user = null,
    ) {
    }
}
