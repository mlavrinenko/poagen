<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class OpensearchConfigRequestCredentials
{
    public function __construct(
        public ?string $password = null,
        public ?string $username = null,
    ) {
    }
}
