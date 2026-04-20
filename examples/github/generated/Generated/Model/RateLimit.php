<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RateLimit
{
    public function __construct(
        public int $limit,
        public int $remaining,
        public int $reset,
        public int $used,
    ) {
    }
}
