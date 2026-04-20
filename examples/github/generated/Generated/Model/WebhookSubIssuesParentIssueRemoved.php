<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookSubIssuesParentIssueRemoved
{
    public function __construct(
        public string $action,
        public Issue $parent_issue,
        public float $parent_issue_id,
        public Repository $parent_issue_repo,
        public Issue $sub_issue,
        public float $sub_issue_id,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?RepositoryWebhooks $repository = null,
        public ?SimpleUser $sender = null,
    ) {
    }
}
