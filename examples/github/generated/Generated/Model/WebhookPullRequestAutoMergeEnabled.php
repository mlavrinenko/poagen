<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestAutoMergeEnabled
{
    public function __construct(
        public string $action,
        public int $number,
        public WebhookPullRequestAutoMergeEnabledPull_request $pull_request,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?string $reason = null,
    ) {
    }
}
