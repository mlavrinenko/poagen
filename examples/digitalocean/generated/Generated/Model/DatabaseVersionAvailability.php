<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DatabaseVersionAvailability
{
    public function __construct(
        public ?string $end_of_availability = null,
        public ?string $end_of_life = null,
        public ?string $version = null,
    ) {
    }
}
