<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppComponentHealth
{
    public function __construct(
        public ?float $cpu_usage_percent = null,
        public ?float $memory_usage_percent = null,
        public ?string $name = null,
        public ?int $replicas_desired = null,
        public ?int $replicas_ready = null,
        public ?string $state = null,
    ) {
    }
}
