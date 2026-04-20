<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppWorkerSpecAutoscalingMetrics
{
    public function __construct(
        public ?AppWorkerSpecAutoscalingMetricsCpu $cpu = null,
    ) {
    }
}
