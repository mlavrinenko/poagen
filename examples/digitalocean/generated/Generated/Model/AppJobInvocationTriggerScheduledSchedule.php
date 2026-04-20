<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppJobInvocationTriggerScheduledSchedule
{
    public function __construct(
        public ?string $cron = null,
        public ?string $time_zone = null,
    ) {
    }
}
