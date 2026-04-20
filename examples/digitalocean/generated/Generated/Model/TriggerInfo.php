<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class TriggerInfo
{
    public function __construct(
        public ?string $created_at = null,
        public ?string $function = null,
        public ?bool $is_enabled = null,
        public ?string $name = null,
        public ?string $namespace = null,
        public ?ScheduledDetails $scheduled_details = null,
        public ?TriggerInfoScheduled_runs $scheduled_runs = null,
        public ?string $type = null,
        public ?string $updated_at = null,
    ) {
    }
}
