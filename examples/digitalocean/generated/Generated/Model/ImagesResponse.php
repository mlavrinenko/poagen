<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ImagesResponse
{
    /**
     * @param list<\Acme\DigitalOcean\Generated\Model\GeneratedImage> $data
     * @param ?mixed $usage
     */
    public function __construct(
        public int $created,
        public array $data,
        public ?string $background = null,
        public ?string $output_format = null,
        public ?string $quality = null,
        public ?string $size = null,
        public $usage = null,
    ) {
    }
}
