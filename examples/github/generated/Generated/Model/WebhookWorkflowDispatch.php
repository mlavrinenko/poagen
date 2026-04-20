<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookWorkflowDispatch
{
    /**
     * @param ?array<string, mixed> $inputs
     */
    public function __construct(
        public ?array $inputs = null,
        public string $ref,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public string $workflow,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
