<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class SubscriptionTierBase
{
    public function __construct(
        public ?bool $allow_storage_overage = null,
        public ?int $included_bandwidth_bytes = null,
        public ?int $included_repositories = null,
        public ?int $included_storage_bytes = null,
        public ?int $monthly_price_in_cents = null,
        public ?string $name = null,
        public ?string $slug = null,
        public ?int $storage_overage_price_in_cents = null,
    ) {
    }
}
