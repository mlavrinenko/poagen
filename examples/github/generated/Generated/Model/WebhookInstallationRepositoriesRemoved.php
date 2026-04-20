<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\WebhooksRepositorySelection;

final readonly class WebhookInstallationRepositoriesRemoved
{
    /**
     * @param list<array<string, mixed>> $repositories_removed
     */
    public function __construct(
        public string $action,
        public Installation $installation,
        public WebhooksRepositoriesAdded $repositories_added,
        public array $repositories_removed,
        public WebhooksRepositorySelection $repository_selection,
        public WebhooksUser $requester,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?RepositoryWebhooks $repository = null,
    ) {
    }
}
