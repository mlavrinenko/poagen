<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ScheduledDetails
{
    public function __construct(
        public string $cron,
        public ?ScheduledDetailsBody $body = null,
    ) {
    }
}
