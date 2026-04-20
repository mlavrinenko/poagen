<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookTeamDeleted
{
    public function __construct(
        public string $action,
        public OrganizationSimpleWebhooks $organization,
        public WebhooksTeam1 $team,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?WebhookTeamDeletedRepository $repository = null,
        public ?SimpleUser $sender = null,
    ) {
    }
}
