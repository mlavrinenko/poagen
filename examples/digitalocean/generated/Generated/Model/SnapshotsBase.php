<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class SnapshotsBase
{
    /**
     * @param list<string> $regions
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public int $min_disk_size,
        public string $name,
        public array $regions,
        public float $size_gigabytes,
    ) {
    }
}
