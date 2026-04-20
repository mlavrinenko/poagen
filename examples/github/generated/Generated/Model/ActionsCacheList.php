<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ActionsCacheList
{
    /**
     * @param list<array<string, mixed>> $actions_caches
     */
    public function __construct(
        public array $actions_caches,
        public int $total_count,
    ) {
    }
}
