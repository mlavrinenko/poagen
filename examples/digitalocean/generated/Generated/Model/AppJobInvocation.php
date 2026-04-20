<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class AppJobInvocation
{
    public function __construct(
        public ?DateTimeImmutable $completed_at = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $deployment_id = null,
        public ?string $id = null,
        public ?string $job_name = null,
        public ?string $phase = null,
        public ?DateTimeImmutable $started_at = null,
        public ?AppJobInvocationTrigger $trigger = null,
    ) {
    }
}
