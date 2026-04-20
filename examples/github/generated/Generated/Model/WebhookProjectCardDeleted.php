<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookProjectCardDeleted
{
    public function __construct(
        public string $action,
        public WebhookProjectCardDeletedProject_card $project_card,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?NullableRepositoryWebhooks $repository = null,
    ) {
    }
}
