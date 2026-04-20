<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class KeySimple
{
    public function __construct(
        public int $id,
        public string $key,
        public ?DateTimeImmutable $created_at = null,
        public ?DateTimeImmutable $last_used = null,
    ) {
    }
}
