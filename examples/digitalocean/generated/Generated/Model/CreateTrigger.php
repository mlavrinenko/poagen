<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class CreateTrigger
{
    public function __construct(
        public string $function,
        public bool $is_enabled,
        public string $name,
        public ScheduledDetails $scheduled_details,
        public string $type,
    ) {
    }
}
