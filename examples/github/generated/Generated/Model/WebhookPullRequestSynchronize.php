<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestSynchronize
{
    public function __construct(
        public string $action,
        public string $after,
        public string $before,
        public WebhooksNumber $number,
        public WebhookPullRequestSynchronizePull_request $pull_request,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
