<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class Snapshots
{
    /**
     * @param list<string> $regions
     * @param ?list<string> $tags
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public string $id,
        public int $min_disk_size,
        public string $name,
        public array $regions,
        public string $resource_id,
        public string $resource_type,
        public float $size_gigabytes,
        public ?array $tags = null,
    ) {
    }
}
