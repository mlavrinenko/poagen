<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class BranchProtection
{
    public function __construct(
        public ?BranchProtectionAllow_deletions $allow_deletions = null,
        public ?BranchProtectionAllow_force_pushes $allow_force_pushes = null,
        public ?BranchProtectionAllow_fork_syncing $allow_fork_syncing = null,
        public ?BranchProtectionBlock_creations $block_creations = null,
        public ?bool $enabled = null,
        public ?ProtectedBranchAdminEnforced $enforce_admins = null,
        public ?BranchProtectionLock_branch $lock_branch = null,
        public ?string $name = null,
        public ?string $protection_url = null,
        public ?BranchProtectionRequired_conversation_resolution $required_conversation_resolution = null,
        public ?BranchProtectionRequired_linear_history $required_linear_history = null,
        public ?ProtectedBranchPullRequestReview $required_pull_request_reviews = null,
        public ?BranchProtectionRequired_signatures $required_signatures = null,
        public ?ProtectedBranchRequiredStatusCheck $required_status_checks = null,
        public ?BranchRestrictionPolicy $restrictions = null,
        public ?string $url = null,
    ) {
    }
}
