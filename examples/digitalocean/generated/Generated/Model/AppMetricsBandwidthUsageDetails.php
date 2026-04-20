<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppMetricsBandwidthUsageDetails
{
    public function __construct(
        public ?string $app_id = null,
        public ?string $bandwidth_bytes = null,
    ) {
    }
}
