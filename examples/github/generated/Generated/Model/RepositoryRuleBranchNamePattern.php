<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleBranchNamePattern implements RepositoryRule, OrgRules
{
    public function __construct(
        public string $type,
        public ?RepositoryRuleBranchNamePatternParameters $parameters = null,
    ) {
    }
}
