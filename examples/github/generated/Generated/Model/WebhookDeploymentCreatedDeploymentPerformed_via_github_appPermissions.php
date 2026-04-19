<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookDeploymentCreatedDeploymentPerformed_via_github_appPermissions implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'actions' => ['actions', null],
        'administration' => ['administration', null],
        'checks' => ['checks', null],
        'content_references' => ['content_references', null],
        'contents' => ['contents', null],
        'deployments' => ['deployments', null],
        'discussions' => ['discussions', null],
        'emails' => ['emails', null],
        'environments' => ['environments', null],
        'issues' => ['issues', null],
        'keys' => ['keys', null],
        'members' => ['members', null],
        'metadata' => ['metadata', null],
        'organization_administration' => ['organization_administration', null],
        'organization_hooks' => ['organization_hooks', null],
        'organization_packages' => ['organization_packages', null],
        'organization_plan' => ['organization_plan', null],
        'organization_projects' => ['organization_projects', null],
        'organization_secrets' => ['organization_secrets', null],
        'organization_self_hosted_runners' => ['organization_self_hosted_runners', null],
        'organization_user_blocking' => ['organization_user_blocking', null],
        'packages' => ['packages', null],
        'pages' => ['pages', null],
        'pull_requests' => ['pull_requests', null],
        'repository_hooks' => ['repository_hooks', null],
        'repository_projects' => ['repository_projects', null],
        'secret_scanning_alerts' => ['secret_scanning_alerts', null],
        'secrets' => ['secrets', null],
        'security_events' => ['security_events', null],
        'security_scanning_alert' => ['security_scanning_alert', null],
        'single_file' => ['single_file', null],
        'statuses' => ['statuses', null],
        'vulnerability_alerts' => ['vulnerability_alerts', null],
        'workflows' => ['workflows', null],
    ];

    public function __construct(
        public ?string $actions = null,
        public ?string $administration = null,
        public ?string $checks = null,
        public ?string $content_references = null,
        public ?string $contents = null,
        public ?string $deployments = null,
        public ?string $discussions = null,
        public ?string $emails = null,
        public ?string $environments = null,
        public ?string $issues = null,
        public ?string $keys = null,
        public ?string $members = null,
        public ?string $metadata = null,
        public ?string $organization_administration = null,
        public ?string $organization_hooks = null,
        public ?string $organization_packages = null,
        public ?string $organization_plan = null,
        public ?string $organization_projects = null,
        public ?string $organization_secrets = null,
        public ?string $organization_self_hosted_runners = null,
        public ?string $organization_user_blocking = null,
        public ?string $packages = null,
        public ?string $pages = null,
        public ?string $pull_requests = null,
        public ?string $repository_hooks = null,
        public ?string $repository_projects = null,
        public ?string $secret_scanning_alerts = null,
        public ?string $secrets = null,
        public ?string $security_events = null,
        public ?string $security_scanning_alert = null,
        public ?string $single_file = null,
        public ?string $statuses = null,
        public ?string $vulnerability_alerts = null,
        public ?string $workflows = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'actions' => $this->actions,
            'administration' => $this->administration,
            'checks' => $this->checks,
            'content_references' => $this->content_references,
            'contents' => $this->contents,
            'deployments' => $this->deployments,
            'discussions' => $this->discussions,
            'emails' => $this->emails,
            'environments' => $this->environments,
            'issues' => $this->issues,
            'keys' => $this->keys,
            'members' => $this->members,
            'metadata' => $this->metadata,
            'organization_administration' => $this->organization_administration,
            'organization_hooks' => $this->organization_hooks,
            'organization_packages' => $this->organization_packages,
            'organization_plan' => $this->organization_plan,
            'organization_projects' => $this->organization_projects,
            'organization_secrets' => $this->organization_secrets,
            'organization_self_hosted_runners' => $this->organization_self_hosted_runners,
            'organization_user_blocking' => $this->organization_user_blocking,
            'packages' => $this->packages,
            'pages' => $this->pages,
            'pull_requests' => $this->pull_requests,
            'repository_hooks' => $this->repository_hooks,
            'repository_projects' => $this->repository_projects,
            'secret_scanning_alerts' => $this->secret_scanning_alerts,
            'secrets' => $this->secrets,
            'security_events' => $this->security_events,
            'security_scanning_alert' => $this->security_scanning_alert,
            'single_file' => $this->single_file,
            'statuses' => $this->statuses,
            'vulnerability_alerts' => $this->vulnerability_alerts,
            'workflows' => $this->workflows,
        ];
    }
}
