<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class NfsSnapshotResponse
{
    public function __construct(
        public DateTimeImmutable $created_at,
        public string $id,
        public string $name,
        public string $region,
        public string $share_id,
        public int $size_gib,
        public string $status,
    ) {
    }
}
