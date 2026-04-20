<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class SubIssuesSummary
{
    public function __construct(
        public int $completed,
        public int $percent_completed,
        public int $total,
    ) {
    }
}
