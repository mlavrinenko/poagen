<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DiskInfoSize
{
    public function __construct(
        public ?int $amount = null,
        public ?string $unit = null,
    ) {
    }
}
