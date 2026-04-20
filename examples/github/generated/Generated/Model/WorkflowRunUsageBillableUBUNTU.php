<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WorkflowRunUsageBillableUBUNTU
{
    /**
     * @param ?list<array<string, mixed>> $job_runs
     */
    public function __construct(
        public int $jobs,
        public int $total_ms,
        public ?array $job_runs = null,
    ) {
    }
}
