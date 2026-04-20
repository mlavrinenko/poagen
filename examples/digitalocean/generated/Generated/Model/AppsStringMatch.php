<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsStringMatch
{
    public function __construct(
        public ?string $exact = null,
        public ?string $prefix = null,
        public ?string $regex = null,
    ) {
    }
}
