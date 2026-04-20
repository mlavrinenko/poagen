<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookIssuesAssigned
{
    public function __construct(
        public string $action,
        public WebhooksIssue $issue,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public ?WebhooksUser $assignee = null,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
