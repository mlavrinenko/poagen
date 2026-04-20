<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class Key
{
    public function __construct(
        public DateTimeImmutable $created_at,
        public int $id,
        public string $key,
        public bool $read_only,
        public string $title,
        public string $url,
        public bool $verified,
        public ?DateTimeImmutable $last_used = null,
    ) {
    }
}
