<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class History
{
    public function __construct(
        public DateTimeImmutable $created_at,
        public int $current_instance_count,
        public int $desired_instance_count,
        public string $history_event_id,
        public string $reason,
        public string $status,
        public DateTimeImmutable $updated_at,
    ) {
    }
}
