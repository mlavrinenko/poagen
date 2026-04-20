<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookIssueDependenciesBlockingRemoved
{
    public function __construct(
        public string $action,
        public OrganizationSimpleWebhooks $organization,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public ?Issue $blocked_issue = null,
        public ?float $blocked_issue_id = null,
        public ?Repository $blocked_issue_repo = null,
        public ?Issue $blocking_issue = null,
        public ?float $blocking_issue_id = null,
        public ?SimpleInstallation $installation = null,
    ) {
    }
}
