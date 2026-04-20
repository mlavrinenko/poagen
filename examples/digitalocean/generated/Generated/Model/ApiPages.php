<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiPages
{
    public function __construct(
        public ?string $first = null,
        public ?string $last = null,
        public ?string $next = null,
        public ?string $previous = null,
    ) {
    }
}
