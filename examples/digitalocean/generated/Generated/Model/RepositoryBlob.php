<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class RepositoryBlob
{
    public function __construct(
        public ?int $compressed_size_bytes = null,
        public ?string $digest = null,
    ) {
    }
}
