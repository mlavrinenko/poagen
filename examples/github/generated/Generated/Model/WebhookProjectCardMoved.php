<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookProjectCardMoved
{
    /**
     * @param mixed $project_card
     */
    public function __construct(
        public string $action,
        public $project_card,
        public SimpleUser $sender,
        public ?WebhookProjectCardMovedChanges $changes = null,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?RepositoryWebhooks $repository = null,
    ) {
    }
}
