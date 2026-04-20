<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleUpdateParameters
{
    public function __construct(
        public bool $update_allows_fetch_and_merge,
    ) {
    }
}
