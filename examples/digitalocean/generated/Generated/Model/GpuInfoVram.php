<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class GpuInfoVram
{
    public function __construct(
        public ?int $amount = null,
        public ?string $unit = null,
    ) {
    }
}
