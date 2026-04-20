<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ReferrerTraffic
{
    public function __construct(
        public int $count,
        public string $referrer,
        public int $uniques,
    ) {
    }
}
