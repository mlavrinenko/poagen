<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class RegistryCreate
{
    public function __construct(
        public string $name,
        public string $subscription_tier_slug,
        public ?string $region = null,
    ) {
    }
}
