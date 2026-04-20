<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewRequestRemovedBranch1 implements WebhookPullRequestReviewRequestRemoved
{
    public function __construct(
        public string $action,
        public int $number,
        public WebhookPullRequestReviewRequestRemovedBranch1Pull_request $pull_request,
        public RepositoryWebhooks $repository,
        public WebhookPullRequestReviewRequestRemovedBranch1Requested_reviewer $requested_reviewer,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
