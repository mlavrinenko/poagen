<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRulePullRequest
{
    public function __construct(
        public string $type,
        public ?RepositoryRulePullRequestParameters $parameters = null,
    ) {
    }
}
