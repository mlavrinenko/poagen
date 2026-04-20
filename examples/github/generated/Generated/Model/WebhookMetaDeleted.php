<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookMetaDeleted
{
    public function __construct(
        public string $action,
        public WebhookMetaDeletedHook $hook,
        public int $hook_id,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?NullableRepositoryWebhooks $repository = null,
        public ?SimpleUser $sender = null,
    ) {
    }
}
