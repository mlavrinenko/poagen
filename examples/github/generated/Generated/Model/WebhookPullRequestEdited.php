<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestEdited
{
    public function __construct(
        public string $action,
        public WebhookPullRequestEditedChanges $changes,
        public WebhooksNumber $number,
        public PullRequestWebhook $pull_request,
        public RepositoryWebhooks $repository,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?SimpleUser $sender = null,
    ) {
    }
}
