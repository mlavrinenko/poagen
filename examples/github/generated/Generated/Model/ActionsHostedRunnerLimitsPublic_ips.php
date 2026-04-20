<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ActionsHostedRunnerLimitsPublic_ips
{
    public function __construct(
        public int $current_usage,
        public int $maximum,
    ) {
    }
}
