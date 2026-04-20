<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppJobSpecAutoscaling
{
    public function __construct(
        public ?int $max_instance_count = null,
        public ?AppJobSpecAutoscalingMetrics $metrics = null,
        public ?int $min_instance_count = null,
    ) {
    }
}
