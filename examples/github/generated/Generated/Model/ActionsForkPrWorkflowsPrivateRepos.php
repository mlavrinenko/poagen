<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ActionsForkPrWorkflowsPrivateRepos
{
    public function __construct(
        public bool $require_approval_for_fork_pr_workflows,
        public bool $run_workflows_from_fork_pull_requests,
        public bool $send_secrets_and_variables,
        public bool $send_write_tokens_to_workflows,
    ) {
    }
}
