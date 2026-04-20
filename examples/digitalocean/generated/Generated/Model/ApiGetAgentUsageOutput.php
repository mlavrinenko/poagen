<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiGetAgentUsageOutput
{
    public function __construct(
        public ?ApiResourceUsage $log_insights_usage = null,
        public ?ApiResourceUsage $usage = null,
    ) {
    }
}
