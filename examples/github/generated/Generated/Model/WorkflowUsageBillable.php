<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WorkflowUsageBillable
{
    public function __construct(
        public ?WorkflowUsageBillableMACOS $MACOS = null,
        public ?WorkflowUsageBillableUBUNTU $UBUNTU = null,
        public ?WorkflowUsageBillableWINDOWS $WINDOWS = null,
    ) {
    }
}
