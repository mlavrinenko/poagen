<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class Kernel
{
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $version = null,
    ) {
    }
}
