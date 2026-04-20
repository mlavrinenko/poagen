<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ByoipPrefixCreate
{
    public function __construct(
        public string $prefix,
        public string $region,
        public string $signature,
    ) {
    }
}
