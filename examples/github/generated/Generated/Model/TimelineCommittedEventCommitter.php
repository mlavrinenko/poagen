<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class TimelineCommittedEventCommitter
{
    public function __construct(
        public DateTimeImmutable $date,
        public string $email,
        public string $name,
    ) {
    }
}
