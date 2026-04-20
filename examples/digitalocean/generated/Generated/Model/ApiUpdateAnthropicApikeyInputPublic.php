<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiUpdateAnthropicApikeyInputPublic
{
    public function __construct(
        public ?string $api_key = null,
        public ?string $api_key_uuid = null,
        public ?string $name = null,
    ) {
    }
}
