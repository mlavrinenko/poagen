<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ClusterStatus
{
    public function __construct(
        public ?string $message = null,
        public ?string $state = null,
    ) {
    }
}
