<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhooksRule
{
    /**
     * @param list<string> $authorized_actor_names
     * @param list<string> $required_status_checks
     */
    public function __construct(
        public bool $admin_enforced,
        public string $allow_deletions_enforcement_level,
        public string $allow_force_pushes_enforcement_level,
        public array $authorized_actor_names,
        public bool $authorized_actors_only,
        public bool $authorized_dismissal_actors_only,
        public DateTimeImmutable $created_at,
        public bool $dismiss_stale_reviews_on_push,
        public int $id,
        public bool $ignore_approvals_from_contributors,
        public string $linear_history_requirement_enforcement_level,
        public string $lock_branch_enforcement_level,
        public string $merge_queue_enforcement_level,
        public string $name,
        public string $pull_request_reviews_enforcement_level,
        public int $repository_id,
        public bool $require_code_owner_review,
        public int $required_approving_review_count,
        public string $required_conversation_resolution_level,
        public string $required_deployments_enforcement_level,
        public array $required_status_checks,
        public string $required_status_checks_enforcement_level,
        public string $signature_requirement_enforcement_level,
        public bool $strict_required_status_checks_policy,
        public DateTimeImmutable $updated_at,
        public ?bool $create_protected = null,
        public ?bool $lock_allows_fork_sync = null,
        public ?bool $require_last_push_approval = null,
    ) {
    }
}
