<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class IssueDependenciesSummary
{
    public function __construct(
        public int $blocked_by,
        public int $blocking,
        public int $total_blocked_by,
        public int $total_blocking,
    ) {
    }
}
