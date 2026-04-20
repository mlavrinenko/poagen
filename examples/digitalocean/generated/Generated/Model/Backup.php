<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class Backup
{
    public function __construct(
        public DateTimeImmutable $created_at,
        public float $size_gigabytes,
        public ?bool $incremental = null,
    ) {
    }
}
