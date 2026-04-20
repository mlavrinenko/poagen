<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class CodespaceWithFullRepository
{
    /**
     * @param list<string> $recent_folders
     */
    public function __construct(
        public SimpleUser $billable_owner,
        public DateTimeImmutable $created_at,
        public ?string $environment_id = null,
        public CodespaceWithFullRepositoryGit_status $git_status,
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
        public FullRepository $repository,
        public string $start_url,
        public string $state,
        public string $stop_url,
        public DateTimeImmutable $updated_at,
        public string $url,
        public string $web_url,
        public ?string $devcontainer_path = null,
        public ?string $display_name = null,
        public ?string $idle_timeout_notice = null,
        public ?bool $pending_operation = null,
        public ?string $pending_operation_disabled_reason = null,
        public ?string $publish_url = null,
        public ?DateTimeImmutable $retention_expires_at = null,
        public ?int $retention_period_minutes = null,
        public ?CodespaceWithFullRepositoryRuntime_constraints $runtime_constraints = null,
    ) {
    }
}
