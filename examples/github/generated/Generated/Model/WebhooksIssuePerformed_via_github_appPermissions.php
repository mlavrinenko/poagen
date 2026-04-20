<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhooksIssuePerformed_via_github_appPermissions
{
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
}
