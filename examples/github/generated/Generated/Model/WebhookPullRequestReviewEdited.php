<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewEdited
{
    public function __construct(
        public string $action,
        public WebhookPullRequestReviewEditedChanges $changes,
        public WebhookPullRequestReviewEditedPull_request $pull_request,
        public RepositoryWebhooks $repository,
        public WebhooksReview $review,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
