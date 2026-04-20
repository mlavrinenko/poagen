<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleBranchNamePattern
{
    public function __construct(
        public string $type,
        public ?RepositoryRuleBranchNamePatternParameters $parameters = null,
    ) {
    }
}
