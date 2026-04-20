<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class Domain
{
    public function __construct(
        public ?string $ip_address = null,
        public ?string $name = null,
        public ?int $ttl = null,
        public ?string $zone_file = null,
    ) {
    }
}
