<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPersonalAccessTokenRequestCreated
{
    public function __construct(
        public string $action,
        public OrganizationSimpleWebhooks $organization,
        public PersonalAccessTokenRequest $personal_access_token_request,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
    ) {
    }
}
