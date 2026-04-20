<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WorkflowRunUsage
{
    public function __construct(
        public WorkflowRunUsageBillable $billable,
        public ?int $run_duration_ms = null,
    ) {
    }
}
