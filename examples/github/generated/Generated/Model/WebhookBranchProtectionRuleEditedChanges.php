<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookBranchProtectionRuleEditedChanges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'admin_enforced' => [
            'admin_enforced',
            \Acme\GitHub\Generated\Model\WebhookBranchProtectionRuleEditedChangesAdmin_enforced::class,
        ],
        'authorized_actor_names' => [
            'authorized_actor_names',
            \Acme\GitHub\Generated\Model\WebhookBranchProtectionRuleEditedChangesAuthorized_actor_names::class,
        ],
        'authorized_actors_only' => [
            'authorized_actors_only',
            \Acme\GitHub\Generated\Model\WebhookBranchProtectionRuleEditedChangesAuthorized_actors_only::class,
        ],
        'authorized_dismissal_actors_only' => [
            'authorized_dismissal_actors_only',
            \Acme\GitHub\Generated\Model\WebhookBranchProtectionRuleEditedChangesAuthorized_dismissal_actors_only::class,
        ],
        'linear_history_requirement_enforcement_level' => [
            'linear_history_requirement_enforcement_level',
            \Acme\GitHub\Generated\Model\WebhookBranchProtectionRuleEditedChangesLinear_history_requirement_enforcement_level::class,
        ],
        'lock_allows_fork_sync' => [
            'lock_allows_fork_sync',
            \Acme\GitHub\Generated\Model\WebhookBranchProtectionRuleEditedChangesLock_allows_fork_sync::class,
        ],
        'lock_branch_enforcement_level' => [
            'lock_branch_enforcement_level',
            \Acme\GitHub\Generated\Model\WebhookBranchProtectionRuleEditedChangesLock_branch_enforcement_level::class,
        ],
        'pull_request_reviews_enforcement_level' => [
            'pull_request_reviews_enforcement_level',
            \Acme\GitHub\Generated\Model\WebhookBranchProtectionRuleEditedChangesPull_request_reviews_enforcement_level::class,
        ],
        'require_last_push_approval' => [
            'require_last_push_approval',
            \Acme\GitHub\Generated\Model\WebhookBranchProtectionRuleEditedChangesRequire_last_push_approval::class,
        ],
        'required_status_checks' => [
            'required_status_checks',
            \Acme\GitHub\Generated\Model\WebhookBranchProtectionRuleEditedChangesRequired_status_checks::class,
        ],
        'required_status_checks_enforcement_level' => [
            'required_status_checks_enforcement_level',
            \Acme\GitHub\Generated\Model\WebhookBranchProtectionRuleEditedChangesRequired_status_checks_enforcement_level::class,
        ],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'admin_enforced' => $this->admin_enforced,
            'authorized_actor_names' => $this->authorized_actor_names,
            'authorized_actors_only' => $this->authorized_actors_only,
            'authorized_dismissal_actors_only' => $this->authorized_dismissal_actors_only,
            'linear_history_requirement_enforcement_level' => $this->linear_history_requirement_enforcement_level,
            'lock_allows_fork_sync' => $this->lock_allows_fork_sync,
            'lock_branch_enforcement_level' => $this->lock_branch_enforcement_level,
            'pull_request_reviews_enforcement_level' => $this->pull_request_reviews_enforcement_level,
            'require_last_push_approval' => $this->require_last_push_approval,
            'required_status_checks' => $this->required_status_checks,
            'required_status_checks_enforcement_level' => $this->required_status_checks_enforcement_level,
        ];
    }
}
