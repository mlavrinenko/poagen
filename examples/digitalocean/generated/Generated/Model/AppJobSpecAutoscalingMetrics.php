<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppJobSpecAutoscalingMetrics
{
    public function __construct(
        public ?AppJobSpecAutoscalingMetricsCpu $cpu = null,
    ) {
    }
}
