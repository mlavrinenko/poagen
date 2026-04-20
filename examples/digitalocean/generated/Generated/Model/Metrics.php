<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class Metrics
{
    public function __construct(
        public MetricsData $data,
        public string $status,
    ) {
    }
}
