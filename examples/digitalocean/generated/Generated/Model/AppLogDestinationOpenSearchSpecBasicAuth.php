<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppLogDestinationOpenSearchSpecBasicAuth
{
    public function __construct(
        public ?string $password = null,
        public ?string $user = null,
    ) {
    }
}
