<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class SshSigningKey
{
    public function __construct(
        public DateTimeImmutable $created_at,
        public int $id,
        public string $key,
        public string $title,
    ) {
    }
}
