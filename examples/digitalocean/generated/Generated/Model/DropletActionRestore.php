<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DropletActionRestore
{
    public function __construct(
        public string $type,
        public ?int $image = null,
    ) {
    }
}
