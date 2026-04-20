<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookCodeScanningAlertReopened
{
    public function __construct(
        public string $action,
        public WebhookCodeScanningAlertReopenedAlert $alert,
        public ?string $commit_oid = null,
        public ?string $ref = null,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
