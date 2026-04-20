<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ActionsCacheRetentionLimitForEnterprise
{
    public function __construct(
        public ?int $max_cache_retention_days = null,
    ) {
    }
}
