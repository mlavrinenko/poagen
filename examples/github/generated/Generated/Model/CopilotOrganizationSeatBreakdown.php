<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CopilotOrganizationSeatBreakdown
{
    public function __construct(
        public ?int $active_this_cycle = null,
        public ?int $added_this_cycle = null,
        public ?int $inactive_this_cycle = null,
        public ?int $pending_cancellation = null,
        public ?int $pending_invitation = null,
        public ?int $total = null,
    ) {
    }
}
