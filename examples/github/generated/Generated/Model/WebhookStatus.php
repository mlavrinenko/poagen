<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookStatus
{
    /**
     * @param list<array<string, mixed>> $branches
     */
    public function __construct(
        public array $branches,
        public WebhookStatusCommit $commit,
        public string $context,
        public string $created_at,
        public ?string $description = null,
        public int $id,
        public string $name,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public string $sha,
        public string $state,
        public ?string $target_url = null,
        public string $updated_at,
        public ?string $avatar_url = null,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
