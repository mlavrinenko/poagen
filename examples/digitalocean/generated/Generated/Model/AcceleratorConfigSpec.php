<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AcceleratorConfigSpec
{
    public function __construct(
        public string $accelerator_slug,
        public int $scale,
        public string $type,
        public ?string $status = null,
    ) {
    }
}
