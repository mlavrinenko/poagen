<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleFileExtensionRestriction implements RepositoryRule, OrgRules
{
    public function __construct(
        public string $type,
        public ?RepositoryRuleFileExtensionRestrictionParameters $parameters = null,
    ) {
    }
}
