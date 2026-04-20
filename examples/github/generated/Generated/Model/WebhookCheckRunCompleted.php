<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookCheckRunCompleted
{
    public function __construct(
        public CheckRunWithSimpleCheckSuite $check_run,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public ?string $action = null,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
