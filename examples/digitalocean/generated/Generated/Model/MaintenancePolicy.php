<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class MaintenancePolicy
{
    public function __construct(
        public ?string $day = null,
        public ?string $duration = null,
        public ?string $start_time = null,
    ) {
    }
}
