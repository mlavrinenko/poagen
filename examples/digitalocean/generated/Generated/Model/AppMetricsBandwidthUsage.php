<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class AppMetricsBandwidthUsage
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppMetricsBandwidthUsageDetails> $app_bandwidth_usage
     */
    public function __construct(
        public ?array $app_bandwidth_usage = null,
        public ?DateTimeImmutable $date = null,
    ) {
    }
}
