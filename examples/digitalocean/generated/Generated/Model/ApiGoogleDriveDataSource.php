<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiGoogleDriveDataSource
{
    public function __construct(
        public ?string $folder_id = null,
        public ?string $refresh_token = null,
    ) {
    }
}
