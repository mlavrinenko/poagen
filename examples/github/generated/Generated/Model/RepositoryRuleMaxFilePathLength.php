<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleMaxFilePathLength implements RepositoryRule, OrgRules
{
    public function __construct(
        public string $type,
        public ?RepositoryRuleMaxFilePathLengthParameters $parameters = null,
    ) {
    }
}
