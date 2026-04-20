<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookSecurityAdvisoryWithdrawn
{
    public function __construct(
        public string $action,
        public WebhookSecurityAdvisoryWithdrawnSecurity_advisory $security_advisory,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?RepositoryWebhooks $repository = null,
        public ?SimpleUser $sender = null,
    ) {
    }
}
