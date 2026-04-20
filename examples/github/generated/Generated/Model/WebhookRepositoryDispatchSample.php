<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookRepositoryDispatchSample
{
    /**
     * @param ?array<string, mixed> $client_payload
     */
    public function __construct(
        public string $action,
        public string $branch,
        public ?array $client_payload = null,
        public SimpleInstallation $installation,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
