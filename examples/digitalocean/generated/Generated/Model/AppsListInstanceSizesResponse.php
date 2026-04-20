<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsListInstanceSizesResponse
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppsInstanceSize> $instance_sizes
     */
    public function __construct(
        public ?float $discount_percent = null,
        public ?array $instance_sizes = null,
    ) {
    }
}
