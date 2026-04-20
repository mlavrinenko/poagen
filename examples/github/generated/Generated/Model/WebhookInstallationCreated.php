<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookInstallationCreated
{
    public function __construct(
        public string $action,
        public Installation $installation,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?WebhooksRepositories $repositories = null,
        public ?RepositoryWebhooks $repository = null,
        public ?WebhooksUser $requester = null,
    ) {
    }
}
