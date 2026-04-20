<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class Member
{
    public function __construct(
        public DateTimeImmutable $created_at,
        public MemberCurrentUtilization $current_utilization,
        public int $droplet_id,
        public string $health_status,
        public string $status,
        public DateTimeImmutable $updated_at,
    ) {
    }
}
