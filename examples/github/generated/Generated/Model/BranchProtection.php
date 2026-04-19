<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class BranchProtection implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'allow_deletions' => ['allow_deletions', \Acme\GitHub\Generated\Model\BranchProtectionAllow_deletions::class],
        'allow_force_pushes' => [
            'allow_force_pushes',
            \Acme\GitHub\Generated\Model\BranchProtectionAllow_force_pushes::class,
        ],
        'allow_fork_syncing' => [
            'allow_fork_syncing',
            \Acme\GitHub\Generated\Model\BranchProtectionAllow_fork_syncing::class,
        ],
        'block_creations' => ['block_creations', \Acme\GitHub\Generated\Model\BranchProtectionBlock_creations::class],
        'enabled' => ['enabled', null],
        'enforce_admins' => ['enforce_admins', \Acme\GitHub\Generated\Model\ProtectedBranchAdminEnforced::class],
        'lock_branch' => ['lock_branch', \Acme\GitHub\Generated\Model\BranchProtectionLock_branch::class],
        'name' => ['name', null],
        'protection_url' => ['protection_url', null],
        'required_conversation_resolution' => [
            'required_conversation_resolution',
            \Acme\GitHub\Generated\Model\BranchProtectionRequired_conversation_resolution::class,
        ],
        'required_linear_history' => [
            'required_linear_history',
            \Acme\GitHub\Generated\Model\BranchProtectionRequired_linear_history::class,
        ],
        'required_pull_request_reviews' => [
            'required_pull_request_reviews',
            \Acme\GitHub\Generated\Model\ProtectedBranchPullRequestReview::class,
        ],
        'required_signatures' => [
            'required_signatures',
            \Acme\GitHub\Generated\Model\BranchProtectionRequired_signatures::class,
        ],
        'required_status_checks' => [
            'required_status_checks',
            \Acme\GitHub\Generated\Model\ProtectedBranchRequiredStatusCheck::class,
        ],
        'restrictions' => ['restrictions', \Acme\GitHub\Generated\Model\BranchRestrictionPolicy::class],
        'url' => ['url', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'allow_deletions' => $this->allow_deletions,
            'allow_force_pushes' => $this->allow_force_pushes,
            'allow_fork_syncing' => $this->allow_fork_syncing,
            'block_creations' => $this->block_creations,
            'enabled' => $this->enabled,
            'enforce_admins' => $this->enforce_admins,
            'lock_branch' => $this->lock_branch,
            'name' => $this->name,
            'protection_url' => $this->protection_url,
            'required_conversation_resolution' => $this->required_conversation_resolution,
            'required_linear_history' => $this->required_linear_history,
            'required_pull_request_reviews' => $this->required_pull_request_reviews,
            'required_signatures' => $this->required_signatures,
            'required_status_checks' => $this->required_status_checks,
            'restrictions' => $this->restrictions,
            'url' => $this->url,
        ];
    }
}
