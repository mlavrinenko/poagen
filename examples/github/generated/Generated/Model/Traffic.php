<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class Traffic
{
    public function __construct(
        public int $count,
        public DateTimeImmutable $timestamp,
        public int $uniques,
    ) {
    }
}
