<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiPresignedUrlFile
{
    public function __construct(
        public ?string $file_name = null,
        public ?string $file_size = null,
    ) {
    }
}
