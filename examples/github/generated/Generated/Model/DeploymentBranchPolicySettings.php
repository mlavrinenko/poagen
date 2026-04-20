<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class DeploymentBranchPolicySettings
{
    public function __construct(
        public bool $custom_branch_policies,
        public bool $protected_branches,
    ) {
    }
}
