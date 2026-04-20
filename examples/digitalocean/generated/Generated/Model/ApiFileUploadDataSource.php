<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiFileUploadDataSource
{
    public function __construct(
        public ?string $original_file_name = null,
        public ?string $size_in_bytes = null,
        public ?string $stored_object_key = null,
    ) {
    }
}
