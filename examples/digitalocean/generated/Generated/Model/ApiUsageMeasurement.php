<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiUsageMeasurement
{
    public function __construct(
        public ?int $tokens = null,
        public ?string $usage_type = null,
    ) {
    }
}
