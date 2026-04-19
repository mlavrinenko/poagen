<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ProtectedBranch implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'url' => ['url', null],
        'allow_deletions' => ['allow_deletions', \Acme\GitHub\Generated\Model\ProtectedBranchAllow_deletions::class],
        'allow_force_pushes' => [
            'allow_force_pushes',
            \Acme\GitHub\Generated\Model\ProtectedBranchAllow_force_pushes::class,
        ],
        'allow_fork_syncing' => [
            'allow_fork_syncing',
            \Acme\GitHub\Generated\Model\ProtectedBranchAllow_fork_syncing::class,
        ],
        'block_creations' => ['block_creations', \Acme\GitHub\Generated\Model\ProtectedBranchBlock_creations::class],
        'enforce_admins' => ['enforce_admins', \Acme\GitHub\Generated\Model\ProtectedBranchEnforce_admins::class],
        'lock_branch' => ['lock_branch', \Acme\GitHub\Generated\Model\ProtectedBranchLock_branch::class],
        'required_conversation_resolution' => [
            'required_conversation_resolution',
            \Acme\GitHub\Generated\Model\ProtectedBranchRequired_conversation_resolution::class,
        ],
        'required_linear_history' => [
            'required_linear_history',
            \Acme\GitHub\Generated\Model\ProtectedBranchRequired_linear_history::class,
        ],
        'required_pull_request_reviews' => [
            'required_pull_request_reviews',
            \Acme\GitHub\Generated\Model\ProtectedBranchRequired_pull_request_reviews::class,
        ],
        'required_signatures' => [
            'required_signatures',
            \Acme\GitHub\Generated\Model\ProtectedBranchRequired_signatures::class,
        ],
        'required_status_checks' => ['required_status_checks', \Acme\GitHub\Generated\Model\StatusCheckPolicy::class],
        'restrictions' => ['restrictions', \Acme\GitHub\Generated\Model\BranchRestrictionPolicy::class],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'url' => $this->url,
            'allow_deletions' => $this->allow_deletions,
            'allow_force_pushes' => $this->allow_force_pushes,
            'allow_fork_syncing' => $this->allow_fork_syncing,
            'block_creations' => $this->block_creations,
            'enforce_admins' => $this->enforce_admins,
            'lock_branch' => $this->lock_branch,
            'required_conversation_resolution' => $this->required_conversation_resolution,
            'required_linear_history' => $this->required_linear_history,
            'required_pull_request_reviews' => $this->required_pull_request_reviews,
            'required_signatures' => $this->required_signatures,
            'required_status_checks' => $this->required_status_checks,
            'restrictions' => $this->restrictions,
        ];
    }
}
