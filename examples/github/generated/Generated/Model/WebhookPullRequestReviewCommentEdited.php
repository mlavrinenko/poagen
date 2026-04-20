<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewCommentEdited
{
    public function __construct(
        public string $action,
        public WebhooksChanges $changes,
        public WebhooksReviewComment $comment,
        public WebhookPullRequestReviewCommentEditedPull_request $pull_request,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
