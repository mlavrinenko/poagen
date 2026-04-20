<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class OrgPrivateRegistryConfigurationWithSelectedRepositories
{
    /**
     * @param ?list<int> $selected_repository_ids
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public string $name,
        public string $registry_type,
        public DateTimeImmutable $updated_at,
        public string $visibility,
        public ?string $account_id = null,
        public ?string $audience = null,
        public ?string $auth_type = null,
        public ?string $aws_region = null,
        public ?string $client_id = null,
        public ?string $domain = null,
        public ?string $domain_owner = null,
        public ?string $identity_mapping_name = null,
        public ?string $jfrog_oidc_provider_name = null,
        public ?bool $replaces_base = null,
        public ?string $role_name = null,
        public ?array $selected_repository_ids = null,
        public ?string $tenant_id = null,
        public ?string $url = null,
        public ?string $username = null,
    ) {
    }
}
