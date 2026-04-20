<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AffectedResource
{
    public function __construct(
        public ?string $name = null,
        public ?string $type = null,
        public ?string $urn = null,
    ) {
    }
}
