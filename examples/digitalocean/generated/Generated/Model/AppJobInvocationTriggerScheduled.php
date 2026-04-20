<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppJobInvocationTriggerScheduled
{
    public function __construct(
        public ?AppJobInvocationTriggerScheduledSchedule $schedule = null,
    ) {
    }
}
