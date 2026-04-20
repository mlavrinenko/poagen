<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class ApiResourceUsage
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiUsageMeasurement> $measurements
     */
    public function __construct(
        public ?array $measurements = null,
        public ?string $resource_uuid = null,
        public ?DateTimeImmutable $start = null,
        public ?DateTimeImmutable $stop = null,
    ) {
    }
}
