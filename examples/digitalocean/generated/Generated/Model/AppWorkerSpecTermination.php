<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppWorkerSpecTermination
{
    public function __construct(
        public ?int $grace_period_seconds = null,
    ) {
    }
}
