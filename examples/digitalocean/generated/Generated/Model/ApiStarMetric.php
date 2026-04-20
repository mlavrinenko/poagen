<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiStarMetric
{
    public function __construct(
        public ?string $metric_uuid = null,
        public ?string $name = null,
        public ?float $success_threshold = null,
        public ?int $success_threshold_pct = null,
    ) {
    }
}
