<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class ApiFilePresignedUrlResponse
{
    public function __construct(
        public ?DateTimeImmutable $expires_at = null,
        public ?string $object_key = null,
        public ?string $original_file_name = null,
        public ?string $presigned_url = null,
    ) {
    }
}
