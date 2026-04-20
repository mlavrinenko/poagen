<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ProtectedBranch
{
    public function __construct(
        public string $url,
        public ?ProtectedBranchAllow_deletions $allow_deletions = null,
        public ?ProtectedBranchAllow_force_pushes $allow_force_pushes = null,
        public ?ProtectedBranchAllow_fork_syncing $allow_fork_syncing = null,
        public ?ProtectedBranchBlock_creations $block_creations = null,
        public ?ProtectedBranchEnforce_admins $enforce_admins = null,
        public ?ProtectedBranchLock_branch $lock_branch = null,
        public ?ProtectedBranchRequired_conversation_resolution $required_conversation_resolution = null,
        public ?ProtectedBranchRequired_linear_history $required_linear_history = null,
        public ?ProtectedBranchRequired_pull_request_reviews $required_pull_request_reviews = null,
        public ?ProtectedBranchRequired_signatures $required_signatures = null,
        public ?StatusCheckPolicy $required_status_checks = null,
        public ?BranchRestrictionPolicy $restrictions = null,
    ) {
    }
}
