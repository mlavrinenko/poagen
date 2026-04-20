<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppServiceSpecAutoscalingMetrics
{
    public function __construct(
        public ?AppServiceSpecAutoscalingMetricsCpu $cpu = null,
    ) {
    }
}
