<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookIssuesOpened
{
    public function __construct(
        public string $action,
        public WebhookIssuesOpenedIssue $issue,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public ?WebhookIssuesOpenedChanges $changes = null,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
