<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookCheckRunRequestedAction
{
    public function __construct(
        public string $action,
        public CheckRunWithSimpleCheckSuite $check_run,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?WebhookCheckRunRequestedActionRequested_action $requested_action = null,
    ) {
    }
}
