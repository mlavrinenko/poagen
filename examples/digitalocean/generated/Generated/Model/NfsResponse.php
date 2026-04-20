<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class NfsResponse
{
    /**
     * @param ?list<string> $vpc_ids
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public string $id,
        public string $name,
        public string $region,
        public int $size_gib,
        public string $status,
        public ?string $host = null,
        public ?string $mount_path = null,
        public ?array $vpc_ids = null,
    ) {
    }
}
