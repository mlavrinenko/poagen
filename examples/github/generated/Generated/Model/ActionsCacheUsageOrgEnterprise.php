<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ActionsCacheUsageOrgEnterprise
{
    public function __construct(
        public int $total_active_caches_count,
        public int $total_active_caches_size_in_bytes,
    ) {
    }
}
