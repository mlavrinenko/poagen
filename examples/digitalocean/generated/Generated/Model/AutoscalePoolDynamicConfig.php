<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AutoscalePoolDynamicConfig
{
    public function __construct(
        public int $max_instances,
        public int $min_instances,
        public ?int $cooldown_minutes = null,
        public ?float $target_cpu_utilization = null,
        public ?float $target_memory_utilization = null,
    ) {
    }
}
