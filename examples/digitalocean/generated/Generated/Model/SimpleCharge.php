<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class SimpleCharge
{
    public function __construct(
        public ?string $amount = null,
        public ?string $name = null,
    ) {
    }
}
