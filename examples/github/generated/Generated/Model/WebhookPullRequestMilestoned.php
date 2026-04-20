<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestMilestoned
{
    public function __construct(
        public string $action,
        public WebhooksNumber $number,
        public WebhooksPullRequest5 $pull_request,
        public RepositoryWebhooks $repository,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?Milestone $milestone = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?SimpleUser $sender = null,
    ) {
    }
}
