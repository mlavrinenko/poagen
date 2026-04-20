<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DropletBackupPolicy
{
    public function __construct(
        public ?int $hour = null,
        public ?string $plan = null,
        public ?int $retention_period_days = null,
        public ?string $weekday = null,
        public ?int $window_length_hours = null,
    ) {
    }
}
