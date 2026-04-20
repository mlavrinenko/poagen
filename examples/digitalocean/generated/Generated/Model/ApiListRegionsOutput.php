<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiListRegionsOutput
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\GenaiapiRegion> $regions
     */
    public function __construct(
        public ?array $regions = null,
    ) {
    }
}
