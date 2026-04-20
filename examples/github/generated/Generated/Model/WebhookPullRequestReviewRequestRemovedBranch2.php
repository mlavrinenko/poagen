<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewRequestRemovedBranch2 implements WebhookPullRequestReviewRequestRemoved
{
    public function __construct(
        public string $action,
        public int $number,
        public WebhookPullRequestReviewRequestRemovedBranch2Pull_request $pull_request,
        public RepositoryWebhooks $repository,
        public WebhookPullRequestReviewRequestRemovedBranch2Requested_team $requested_team,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
