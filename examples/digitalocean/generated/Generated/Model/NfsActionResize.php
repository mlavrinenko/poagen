<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class NfsActionResize
{
    public function __construct(
        public string $type,
        public ?NfsActionResizeParams $params = null,
        public ?string $region = null,
    ) {
    }
}
