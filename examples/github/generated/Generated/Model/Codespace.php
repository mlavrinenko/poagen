<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Codespace implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'billable_owner' => ['billable_owner', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'created_at' => ['created_at', ['datetime', null]],
        'environment_id' => ['environment_id', null],
        'git_status' => ['git_status', \Acme\GitHub\Generated\Model\CodespaceGit_status::class],
        'id' => ['id', null],
        'idle_timeout_minutes' => ['idle_timeout_minutes', null],
        'last_used_at' => ['last_used_at', ['datetime', null]],
        'location' => ['location', null],
        'machine' => ['machine', \Acme\GitHub\Generated\Model\NullableCodespaceMachine::class],
        'machines_url' => ['machines_url', null],
        'name' => ['name', null],
        'owner' => ['owner', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'prebuild' => ['prebuild', null],
        'pulls_url' => ['pulls_url', null],
        'recent_folders' => ['recent_folders', ['list', null]],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\MinimalRepository::class],
        'start_url' => ['start_url', null],
        'state' => ['state', null],
        'stop_url' => ['stop_url', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'web_url' => ['web_url', null],
        'devcontainer_path' => ['devcontainer_path', null],
        'display_name' => ['display_name', null],
        'idle_timeout_notice' => ['idle_timeout_notice', null],
        'last_known_stop_notice' => ['last_known_stop_notice', null],
        'pending_operation' => ['pending_operation', null],
        'pending_operation_disabled_reason' => ['pending_operation_disabled_reason', null],
        'publish_url' => ['publish_url', null],
        'retention_expires_at' => ['retention_expires_at', ['datetime', null]],
        'retention_period_minutes' => ['retention_period_minutes', null],
        'runtime_constraints' => ['runtime_constraints', \Acme\GitHub\Generated\Model\CodespaceRuntime_constraints::class],
    ];

    /**
     * @param list<string> $recent_folders
     */
    public function __construct(
        public SimpleUser $billable_owner,
        public DateTimeImmutable $created_at,
        public ?string $environment_id = null,
        public CodespaceGit_status $git_status,
        public int $id,
        public ?int $idle_timeout_minutes = null,
        public DateTimeImmutable $last_used_at,
        public string $location,
        public NullableCodespaceMachine $machine,
        public string $machines_url,
        public string $name,
        public SimpleUser $owner,
        public ?bool $prebuild = null,
        public ?string $pulls_url = null,
        public array $recent_folders,
        public MinimalRepository $repository,
        public string $start_url,
        public string $state,
        public string $stop_url,
        public DateTimeImmutable $updated_at,
        public string $url,
        public string $web_url,
        public ?string $devcontainer_path = null,
        public ?string $display_name = null,
        public ?string $idle_timeout_notice = null,
        public ?string $last_known_stop_notice = null,
        public ?bool $pending_operation = null,
        public ?string $pending_operation_disabled_reason = null,
        public ?string $publish_url = null,
        public ?DateTimeImmutable $retention_expires_at = null,
        public ?int $retention_period_minutes = null,
        public ?CodespaceRuntime_constraints $runtime_constraints = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'billable_owner' => $this->billable_owner,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'environment_id' => $this->environment_id,
            'git_status' => $this->git_status,
            'id' => $this->id,
            'idle_timeout_minutes' => $this->idle_timeout_minutes,
            'last_used_at' => $this->last_used_at->format(\DateTimeInterface::RFC3339),
            'location' => $this->location,
            'machine' => $this->machine,
            'machines_url' => $this->machines_url,
            'name' => $this->name,
            'owner' => $this->owner,
            'prebuild' => $this->prebuild,
            'pulls_url' => $this->pulls_url,
            'recent_folders' => $this->recent_folders,
            'repository' => $this->repository,
            'start_url' => $this->start_url,
            'state' => $this->state,
            'stop_url' => $this->stop_url,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'web_url' => $this->web_url,
            'devcontainer_path' => $this->devcontainer_path,
            'display_name' => $this->display_name,
            'idle_timeout_notice' => $this->idle_timeout_notice,
            'last_known_stop_notice' => $this->last_known_stop_notice,
            'pending_operation' => $this->pending_operation,
            'pending_operation_disabled_reason' => $this->pending_operation_disabled_reason,
            'publish_url' => $this->publish_url,
            'retention_expires_at' => $this->retention_expires_at?->format(\DateTimeInterface::RFC3339),
            'retention_period_minutes' => $this->retention_period_minutes,
            'runtime_constraints' => $this->runtime_constraints,
        ];
    }
}
