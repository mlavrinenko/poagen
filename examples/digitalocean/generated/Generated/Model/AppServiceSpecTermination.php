<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppServiceSpecTermination
{
    public function __construct(
        public ?int $drain_seconds = null,
        public ?int $grace_period_seconds = null,
    ) {
    }
}
