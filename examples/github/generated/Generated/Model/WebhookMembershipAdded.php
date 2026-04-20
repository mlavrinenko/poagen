<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookMembershipAdded
{
    public function __construct(
        public string $action,
        public WebhooksUser $member,
        public OrganizationSimpleWebhooks $organization,
        public string $scope,
        public WebhookMembershipAddedSender $sender,
        public WebhooksTeam $team,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?RepositoryWebhooks $repository = null,
    ) {
    }
}
