<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiDropboxDataSource
{
    public function __construct(
        public ?string $folder = null,
        public ?string $refresh_token = null,
    ) {
    }
}
