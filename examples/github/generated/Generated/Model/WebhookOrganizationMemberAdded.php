<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookOrganizationMemberAdded
{
    public function __construct(
        public string $action,
        public WebhooksMembership $membership,
        public OrganizationSimpleWebhooks $organization,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?RepositoryWebhooks $repository = null,
    ) {
    }
}
