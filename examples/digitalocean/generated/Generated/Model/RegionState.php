<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class RegionState
{
    public function __construct(
        public ?string $status = null,
        public ?string $status_changed_at = null,
        public ?float $thirty_day_uptime_percentage = null,
    ) {
    }
}
