<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookCodeScanningAlertCreated
{
    public function __construct(
        public string $action,
        public WebhookCodeScanningAlertCreatedAlert $alert,
        public WebhooksCodeScanningCommitOid $commit_oid,
        public WebhooksCodeScanningRef $ref,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
