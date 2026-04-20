<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DatabaseRegionOptions
{
    /**
     * @param ?list<string> $regions
     */
    public function __construct(
        public ?array $regions = null,
    ) {
    }
}
