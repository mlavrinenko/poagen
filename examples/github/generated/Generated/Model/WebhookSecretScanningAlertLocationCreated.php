<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookSecretScanningAlertLocationCreated
{
    public function __construct(
        public SecretScanningAlertWebhook $alert,
        public SecretScanningLocation $location,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public ?string $action = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
