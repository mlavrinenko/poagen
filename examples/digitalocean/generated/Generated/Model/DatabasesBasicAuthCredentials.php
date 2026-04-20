<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DatabasesBasicAuthCredentials
{
    public function __construct(
        public ?string $basic_auth_password = null,
        public ?string $basic_auth_username = null,
    ) {
    }
}
