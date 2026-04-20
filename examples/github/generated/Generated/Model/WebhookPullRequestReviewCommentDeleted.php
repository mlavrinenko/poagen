<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewCommentDeleted
{
    public function __construct(
        public string $action,
        public WebhooksReviewComment $comment,
        public WebhookPullRequestReviewCommentDeletedPull_request $pull_request,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
