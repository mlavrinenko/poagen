<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiAgreement
{
    public function __construct(
        public ?string $description = null,
        public ?string $name = null,
        public ?string $url = null,
        public ?string $uuid = null,
    ) {
    }
}
