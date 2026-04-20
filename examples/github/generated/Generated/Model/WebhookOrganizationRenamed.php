<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookOrganizationRenamed
{
    public function __construct(
        public string $action,
        public OrganizationSimpleWebhooks $organization,
        public SimpleUser $sender,
        public ?WebhookOrganizationRenamedChanges $changes = null,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?WebhooksMembership $membership = null,
        public ?RepositoryWebhooks $repository = null,
    ) {
    }
}
