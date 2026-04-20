<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookRepositoryAdvisoryPublished
{
    public function __construct(
        public string $action,
        public RepositoryWebhooks $repository,
        public RepositoryAdvisory $repository_advisory,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?SimpleUser $sender = null,
    ) {
    }
}
