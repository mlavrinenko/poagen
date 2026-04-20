<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CommitActivity
{
    /**
     * @param list<int> $days
     */
    public function __construct(
        public array $days,
        public int $total,
        public int $week,
    ) {
    }
}
