<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class Grant
{
    public function __construct(
        public string $bucket,
        public string $permission,
    ) {
    }
}
