<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class GarbageCollection
{
    public function __construct(
        public ?int $blobs_deleted = null,
        public ?DateTimeImmutable $created_at = null,
        public ?int $freed_bytes = null,
        public ?string $registry_name = null,
        public ?string $status = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $uuid = null,
    ) {
    }
}
