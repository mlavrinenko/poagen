<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookProjectDeleted
{
    public function __construct(
        public string $action,
        public WebhooksProject $project,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?NullableRepositoryWebhooks $repository = null,
        public ?SimpleUser $sender = null,
    ) {
    }
}
