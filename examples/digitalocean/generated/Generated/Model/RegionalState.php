<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class RegionalState
{
    public function __construct(
        public ?RegionState $eu_west = null,
        public ?RegionState $us_east = null,
    ) {
    }
}
