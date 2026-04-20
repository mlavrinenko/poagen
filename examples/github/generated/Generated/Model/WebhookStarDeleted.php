<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookStarDeleted
{
    /**
     * @param ?mixed $starred_at
     */
    public function __construct(
        public string $action,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public $starred_at = null,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
