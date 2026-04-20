<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DedicatedInferenceSizesResponse
{
    /**
     * @param ?list<string> $enabled_regions
     * @param ?list<\Acme\DigitalOcean\Generated\Model\DedicatedInferenceSize> $sizes
     */
    public function __construct(
        public ?array $enabled_regions = null,
        public ?array $sizes = null,
    ) {
    }
}
