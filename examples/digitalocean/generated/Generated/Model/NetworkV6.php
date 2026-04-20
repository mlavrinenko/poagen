<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class NetworkV6
{
    public function __construct(
        public ?string $gateway = null,
        public ?string $ip_address = null,
        public ?int $netmask = null,
        public ?string $type = null,
    ) {
    }
}
