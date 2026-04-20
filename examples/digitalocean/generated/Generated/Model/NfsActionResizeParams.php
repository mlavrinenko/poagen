<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class NfsActionResizeParams
{
    public function __construct(
        public int $size_gib,
    ) {
    }
}
