<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DiskInfo
{
    public function __construct(
        public ?DiskInfoSize $size = null,
        public ?string $type = null,
    ) {
    }
}
