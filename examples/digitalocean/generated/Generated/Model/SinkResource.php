<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class SinkResource
{
    public function __construct(
        public string $urn,
        public ?string $name = null,
    ) {
    }
}
