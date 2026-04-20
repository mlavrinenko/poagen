<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookOrgBlockBlocked
{
    public function __construct(
        public string $action,
        public WebhooksUser $blocked_user,
        public OrganizationSimpleWebhooks $organization,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?RepositoryWebhooks $repository = null,
    ) {
    }
}
