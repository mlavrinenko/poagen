<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class PendingDeployment
{
    /**
     * @param list<array<string, mixed>> $reviewers
     */
    public function __construct(
        public bool $current_user_can_approve,
        public PendingDeploymentEnvironment $environment,
        public array $reviewers,
        public int $wait_timer,
        public ?DateTimeImmutable $wait_timer_started_at = null,
    ) {
    }
}
