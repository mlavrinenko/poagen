<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleCommitAuthorEmailPattern
{
    public function __construct(
        public string $type,
        public ?RepositoryRuleCommitAuthorEmailPatternParameters $parameters = null,
    ) {
    }
}
