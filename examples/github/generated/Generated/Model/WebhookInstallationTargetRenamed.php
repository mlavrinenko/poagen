<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookInstallationTargetRenamed
{
    public function __construct(
        public WebhookInstallationTargetRenamedAccount $account,
        public string $action,
        public WebhookInstallationTargetRenamedChanges $changes,
        public SimpleInstallation $installation,
        public string $target_type,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?RepositoryWebhooks $repository = null,
        public ?SimpleUser $sender = null,
    ) {
    }
}
