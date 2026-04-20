<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DedicatedInferenceSize
{
    public function __construct(
        public ?string $currency = null,
        public ?string $gpu_slug = null,
        public ?string $price_per_hour = null,
        public ?string $region = null,
    ) {
    }
}
