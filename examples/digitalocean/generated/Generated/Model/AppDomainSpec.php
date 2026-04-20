<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppDomainSpec
{
    public function __construct(
        public string $domain,
        public ?string $minimum_tls_version = null,
        public ?string $type = null,
        public ?bool $wildcard = null,
        public ?string $zone = null,
    ) {
    }
}
