<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DropletActionSnapshot
{
    public function __construct(
        public string $type,
        public ?string $name = null,
    ) {
    }
}
