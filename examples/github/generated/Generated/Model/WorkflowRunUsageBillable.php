<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WorkflowRunUsageBillable
{
    public function __construct(
        public ?WorkflowRunUsageBillableMACOS $MACOS = null,
        public ?WorkflowRunUsageBillableUBUNTU $UBUNTU = null,
        public ?WorkflowRunUsageBillableWINDOWS $WINDOWS = null,
    ) {
    }
}
