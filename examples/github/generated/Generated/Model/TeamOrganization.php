<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class TeamOrganization
{
    public function __construct(
        public ?DateTimeImmutable $archived_at = null,
        public string $avatar_url,
        public DateTimeImmutable $created_at,
        public ?string $description = null,
        public string $events_url,
        public int $followers,
        public int $following,
        public bool $has_organization_projects,
        public bool $has_repository_projects,
        public string $hooks_url,
        public string $html_url,
        public int $id,
        public string $issues_url,
        public string $login,
        public string $members_url,
        public string $node_id,
        public int $public_gists,
        public string $public_members_url,
        public int $public_repos,
        public string $repos_url,
        public string $type,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?string $billing_email = null,
        public ?string $blog = null,
        public ?int $collaborators = null,
        public ?string $company = null,
        public ?string $default_repository_permission = null,
        public ?int $disk_usage = null,
        public ?string $email = null,
        public ?bool $is_verified = null,
        public ?string $location = null,
        public ?string $members_allowed_repository_creation_type = null,
        public ?bool $members_can_create_internal_repositories = null,
        public ?bool $members_can_create_pages = null,
        public ?bool $members_can_create_private_pages = null,
        public ?bool $members_can_create_private_repositories = null,
        public ?bool $members_can_create_public_pages = null,
        public ?bool $members_can_create_public_repositories = null,
        public ?bool $members_can_create_repositories = null,
        public ?bool $members_can_fork_private_repositories = null,
        public ?string $name = null,
        public ?int $owned_private_repos = null,
        public ?TeamOrganizationPlan $plan = null,
        public ?int $private_gists = null,
        public ?int $total_private_repos = null,
        public ?string $twitter_username = null,
        public ?bool $two_factor_requirement_enabled = null,
        public ?bool $web_commit_signoff_required = null,
    ) {
    }
}
