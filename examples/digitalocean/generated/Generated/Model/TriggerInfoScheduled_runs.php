<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class TriggerInfoScheduled_runs
{
    public function __construct(
        public ?string $last_run_at = null,
        public ?string $next_run_at = null,
    ) {
    }
}
