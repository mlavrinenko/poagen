<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class NfsAction
{
    public function __construct(
        public string $type,
        public ?string $region = null,
    ) {
    }
}
