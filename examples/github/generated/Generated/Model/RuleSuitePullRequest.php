<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RuleSuitePullRequest
{
    public function __construct(
        public ?RuleSuitePullRequestPull_request $pull_request = null,
    ) {
    }
}
