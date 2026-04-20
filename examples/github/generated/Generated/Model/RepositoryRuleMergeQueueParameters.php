<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleMergeQueueParameters
{
    public function __construct(
        public int $check_response_timeout_minutes,
        public string $grouping_strategy,
        public int $max_entries_to_build,
        public int $max_entries_to_merge,
        public string $merge_method,
        public int $min_entries_to_merge,
        public int $min_entries_to_merge_wait_minutes,
    ) {
    }
}
