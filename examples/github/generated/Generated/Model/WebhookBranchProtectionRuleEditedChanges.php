<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookBranchProtectionRuleEditedChanges
{
    public function __construct(
        public ?WebhookBranchProtectionRuleEditedChangesAdmin_enforced $admin_enforced = null,
        public ?WebhookBranchProtectionRuleEditedChangesAuthorized_actor_names $authorized_actor_names = null,
        public ?WebhookBranchProtectionRuleEditedChangesAuthorized_actors_only $authorized_actors_only = null,
        public ?WebhookBranchProtectionRuleEditedChangesAuthorized_dismissal_actors_only $authorized_dismissal_actors_only = null,
        public ?WebhookBranchProtectionRuleEditedChangesLinear_history_requirement_enforcement_level $linear_history_requirement_enforcement_level = null,
        public ?WebhookBranchProtectionRuleEditedChangesLock_allows_fork_sync $lock_allows_fork_sync = null,
        public ?WebhookBranchProtectionRuleEditedChangesLock_branch_enforcement_level $lock_branch_enforcement_level = null,
        public ?WebhookBranchProtectionRuleEditedChangesPull_request_reviews_enforcement_level $pull_request_reviews_enforcement_level = null,
        public ?WebhookBranchProtectionRuleEditedChangesRequire_last_push_approval $require_last_push_approval = null,
        public ?WebhookBranchProtectionRuleEditedChangesRequired_status_checks $required_status_checks = null,
        public ?WebhookBranchProtectionRuleEditedChangesRequired_status_checks_enforcement_level $required_status_checks_enforcement_level = null,
    ) {
    }
}
