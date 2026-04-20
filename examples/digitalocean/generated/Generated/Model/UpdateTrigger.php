<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class UpdateTrigger
{
    public function __construct(
        public ?bool $is_enabled = null,
        public ?ScheduledDetails $scheduled_details = null,
    ) {
    }
}
