<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AutoscalePoolStaticConfig
{
    public function __construct(
        public int $target_number_instances,
    ) {
    }
}
