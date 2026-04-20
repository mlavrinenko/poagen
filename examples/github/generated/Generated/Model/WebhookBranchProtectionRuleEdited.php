<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookBranchProtectionRuleEdited
{
    public function __construct(
        public string $action,
        public RepositoryWebhooks $repository,
        public WebhooksRule $rule,
        public SimpleUser $sender,
        public ?WebhookBranchProtectionRuleEditedChanges $changes = null,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
