<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookMemberAdded
{
    public function __construct(
        public string $action,
        public WebhooksUser $member,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public ?WebhookMemberAddedChanges $changes = null,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
