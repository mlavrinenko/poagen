<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AccessKeyCreateRequest
{
    public function __construct(
        public string $name,
        public ?string $expires_in = null,
    ) {
    }
}
