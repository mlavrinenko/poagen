<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ActionsCacheUsageByRepository
{
    public function __construct(
        public int $active_caches_count,
        public int $active_caches_size_in_bytes,
        public string $full_name,
    ) {
    }
}
