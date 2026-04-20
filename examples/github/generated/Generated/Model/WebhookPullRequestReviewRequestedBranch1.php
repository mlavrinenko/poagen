<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewRequestedBranch1 implements WebhookPullRequestReviewRequested
{
    public function __construct(
        public string $action,
        public int $number,
        public WebhookPullRequestReviewRequestedBranch1Pull_request $pull_request,
        public RepositoryWebhooks $repository,
        public WebhookPullRequestReviewRequestedBranch1Requested_reviewer $requested_reviewer,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
