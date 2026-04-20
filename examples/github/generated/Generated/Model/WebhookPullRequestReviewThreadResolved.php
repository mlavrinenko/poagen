<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookPullRequestReviewThreadResolved
{
    public function __construct(
        public string $action,
        public WebhookPullRequestReviewThreadResolvedPull_request $pull_request,
        public RepositoryWebhooks $repository,
        public WebhookPullRequestReviewThreadResolvedThread $thread,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?SimpleUser $sender = null,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }
}
