<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class Destination
{
    public function __construct(
        public OpensearchConfig $config,
        public ?string $id = null,
        public ?string $name = null,
        public ?string $type = null,
    ) {
    }
}
