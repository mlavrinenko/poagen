<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DropletActionResize
{
    public function __construct(
        public string $type,
        public ?bool $disk = null,
        public ?string $size = null,
    ) {
    }
}
