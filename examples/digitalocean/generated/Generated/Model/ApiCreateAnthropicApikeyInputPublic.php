<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiCreateAnthropicApikeyInputPublic
{
    public function __construct(
        public ?string $api_key = null,
        public ?string $name = null,
    ) {
    }
}
