<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookTeamAdd
{
    public function __construct(
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public WebhooksTeam1 $team,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
