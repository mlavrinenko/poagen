<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhooksRule implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'admin_enforced' => ['admin_enforced', null],
        'allow_deletions_enforcement_level' => ['allow_deletions_enforcement_level', null],
        'allow_force_pushes_enforcement_level' => ['allow_force_pushes_enforcement_level', null],
        'authorized_actor_names' => ['authorized_actor_names', ['list', null]],
        'authorized_actors_only' => ['authorized_actors_only', null],
        'authorized_dismissal_actors_only' => ['authorized_dismissal_actors_only', null],
        'created_at' => ['created_at', ['datetime', null]],
        'dismiss_stale_reviews_on_push' => ['dismiss_stale_reviews_on_push', null],
        'id' => ['id', null],
        'ignore_approvals_from_contributors' => ['ignore_approvals_from_contributors', null],
        'linear_history_requirement_enforcement_level' => ['linear_history_requirement_enforcement_level', null],
        'lock_branch_enforcement_level' => ['lock_branch_enforcement_level', null],
        'merge_queue_enforcement_level' => ['merge_queue_enforcement_level', null],
        'name' => ['name', null],
        'pull_request_reviews_enforcement_level' => ['pull_request_reviews_enforcement_level', null],
        'repository_id' => ['repository_id', null],
        'require_code_owner_review' => ['require_code_owner_review', null],
        'required_approving_review_count' => ['required_approving_review_count', null],
        'required_conversation_resolution_level' => ['required_conversation_resolution_level', null],
        'required_deployments_enforcement_level' => ['required_deployments_enforcement_level', null],
        'required_status_checks' => ['required_status_checks', ['list', null]],
        'required_status_checks_enforcement_level' => ['required_status_checks_enforcement_level', null],
        'signature_requirement_enforcement_level' => ['signature_requirement_enforcement_level', null],
        'strict_required_status_checks_policy' => ['strict_required_status_checks_policy', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'create_protected' => ['create_protected', null],
        'lock_allows_fork_sync' => ['lock_allows_fork_sync', null],
        'require_last_push_approval' => ['require_last_push_approval', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'admin_enforced' => $this->admin_enforced,
            'allow_deletions_enforcement_level' => $this->allow_deletions_enforcement_level,
            'allow_force_pushes_enforcement_level' => $this->allow_force_pushes_enforcement_level,
            'authorized_actor_names' => $this->authorized_actor_names,
            'authorized_actors_only' => $this->authorized_actors_only,
            'authorized_dismissal_actors_only' => $this->authorized_dismissal_actors_only,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'dismiss_stale_reviews_on_push' => $this->dismiss_stale_reviews_on_push,
            'id' => $this->id,
            'ignore_approvals_from_contributors' => $this->ignore_approvals_from_contributors,
            'linear_history_requirement_enforcement_level' => $this->linear_history_requirement_enforcement_level,
            'lock_branch_enforcement_level' => $this->lock_branch_enforcement_level,
            'merge_queue_enforcement_level' => $this->merge_queue_enforcement_level,
            'name' => $this->name,
            'pull_request_reviews_enforcement_level' => $this->pull_request_reviews_enforcement_level,
            'repository_id' => $this->repository_id,
            'require_code_owner_review' => $this->require_code_owner_review,
            'required_approving_review_count' => $this->required_approving_review_count,
            'required_conversation_resolution_level' => $this->required_conversation_resolution_level,
            'required_deployments_enforcement_level' => $this->required_deployments_enforcement_level,
            'required_status_checks' => $this->required_status_checks,
            'required_status_checks_enforcement_level' => $this->required_status_checks_enforcement_level,
            'signature_requirement_enforcement_level' => $this->signature_requirement_enforcement_level,
            'strict_required_status_checks_policy' => $this->strict_required_status_checks_policy,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'create_protected' => $this->create_protected,
            'lock_allows_fork_sync' => $this->lock_allows_fork_sync,
            'require_last_push_approval' => $this->require_last_push_approval,
        ];
    }
}
