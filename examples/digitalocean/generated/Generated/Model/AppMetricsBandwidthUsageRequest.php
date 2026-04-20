<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class AppMetricsBandwidthUsageRequest
{
    /**
     * @param list<string> $app_ids
     */
    public function __construct(
        public array $app_ids,
        public ?DateTimeImmutable $date = null,
    ) {
    }
}
