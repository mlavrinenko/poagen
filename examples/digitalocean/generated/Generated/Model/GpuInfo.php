<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class GpuInfo
{
    public function __construct(
        public ?int $count = null,
        public ?string $model = null,
        public ?GpuInfoVram $vram = null,
    ) {
    }
}
