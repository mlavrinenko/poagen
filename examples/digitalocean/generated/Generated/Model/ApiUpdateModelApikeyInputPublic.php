<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiUpdateModelApikeyInputPublic
{
    public function __construct(
        public ?string $api_key_uuid = null,
        public ?string $name = null,
    ) {
    }
}
