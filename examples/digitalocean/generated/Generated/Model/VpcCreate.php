<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class VpcCreate
{
    public function __construct(
        public ?string $ip_range = null,
        public ?string $region = null,
    ) {
    }
}
