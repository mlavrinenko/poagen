<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class HealthCheck
{
    public function __construct(
        public ?int $check_interval_seconds = null,
        public ?int $healthy_threshold = null,
        public ?string $path = null,
        public ?int $port = null,
        public ?string $protocol = null,
        public ?int $response_timeout_seconds = null,
        public ?int $unhealthy_threshold = null,
    ) {
    }
}
