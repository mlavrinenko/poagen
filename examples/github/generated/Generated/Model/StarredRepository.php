<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class StarredRepository
{
    public function __construct(
        public Repository $repo,
        public DateTimeImmutable $starred_at,
    ) {
    }
}
