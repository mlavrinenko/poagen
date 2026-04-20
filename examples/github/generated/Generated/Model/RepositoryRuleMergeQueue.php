<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleMergeQueue implements RepositoryRule
{
    public function __construct(
        public string $type,
        public ?RepositoryRuleMergeQueueParameters $parameters = null,
    ) {
    }
}
