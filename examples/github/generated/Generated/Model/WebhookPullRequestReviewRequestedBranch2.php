<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewRequestedBranch2 implements WebhookPullRequestReviewRequested
{
    public function __construct(
        public string $action,
        public int $number,
        public WebhookPullRequestReviewRequestedBranch2Pull_request $pull_request,
        public RepositoryWebhooks $repository,
        public WebhookPullRequestReviewRequestedBranch2Requested_team $requested_team,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
