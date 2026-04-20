<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookIssuesEdited
{
    public function __construct(
        public string $action,
        public WebhookIssuesEditedChanges $changes,
        public WebhookIssuesEditedIssue $issue,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?WebhooksLabel $label = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
