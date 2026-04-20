<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ReservedIpCreateReserveToRegion implements ReservedIpCreate
{
    public function __construct(
        public string $region,
        public ?string $project_id = null,
    ) {
    }
}
