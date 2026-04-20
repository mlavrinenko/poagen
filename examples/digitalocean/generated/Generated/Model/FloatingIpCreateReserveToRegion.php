<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class FloatingIpCreateReserveToRegion implements FloatingIpCreate
{
    public function __construct(
        public string $region,
        public ?string $project_id = null,
    ) {
    }
}
