<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class MultiregistryCreate
{
    public function __construct(
        public string $name,
        public ?string $region = null,
        public ?string $subscription_tier_slug = null,
    ) {
    }
}
