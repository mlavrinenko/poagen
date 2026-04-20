<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsListRegionsResponse
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppsRegion> $regions
     */
    public function __construct(
        public ?array $regions = null,
    ) {
    }
}
