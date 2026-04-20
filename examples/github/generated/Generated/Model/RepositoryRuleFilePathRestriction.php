<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleFilePathRestriction
{
    public function __construct(
        public string $type,
        public ?RepositoryRuleFilePathRestrictionParameters $parameters = null,
    ) {
    }
}
