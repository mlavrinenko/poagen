<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DropletActionChangeKernel
{
    public function __construct(
        public string $type,
        public ?int $kernel = null,
    ) {
    }
}
