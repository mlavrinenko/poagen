<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookTeamEdited
{
    public function __construct(
        public string $action,
        public WebhookTeamEditedChanges $changes,
        public OrganizationSimpleWebhooks $organization,
        public SimpleUser $sender,
        public WebhooksTeam1 $team,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?WebhookTeamEditedRepository $repository = null,
    ) {
    }
}
