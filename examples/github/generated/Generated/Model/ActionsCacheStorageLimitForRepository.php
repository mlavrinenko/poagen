<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ActionsCacheStorageLimitForRepository
{
    public function __construct(
        public ?int $max_cache_size_gb = null,
    ) {
    }
}
