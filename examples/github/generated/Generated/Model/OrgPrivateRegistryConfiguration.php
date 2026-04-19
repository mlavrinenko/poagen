<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class OrgPrivateRegistryConfiguration implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'name' => ['name', null],
        'registry_type' => ['registry_type', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'visibility' => ['visibility', null],
        'account_id' => ['account_id', null],
        'audience' => ['audience', null],
        'auth_type' => ['auth_type', null],
        'aws_region' => ['aws_region', null],
        'client_id' => ['client_id', null],
        'domain' => ['domain', null],
        'domain_owner' => ['domain_owner', null],
        'identity_mapping_name' => ['identity_mapping_name', null],
        'jfrog_oidc_provider_name' => ['jfrog_oidc_provider_name', null],
        'replaces_base' => ['replaces_base', null],
        'role_name' => ['role_name', null],
        'tenant_id' => ['tenant_id', null],
        'url' => ['url', null],
        'username' => ['username', null],
    ];

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
        public ?string $tenant_id = null,
        public ?string $url = null,
        public ?string $username = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'name' => $this->name,
            'registry_type' => $this->registry_type,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'visibility' => $this->visibility,
            'account_id' => $this->account_id,
            'audience' => $this->audience,
            'auth_type' => $this->auth_type,
            'aws_region' => $this->aws_region,
            'client_id' => $this->client_id,
            'domain' => $this->domain,
            'domain_owner' => $this->domain_owner,
            'identity_mapping_name' => $this->identity_mapping_name,
            'jfrog_oidc_provider_name' => $this->jfrog_oidc_provider_name,
            'replaces_base' => $this->replaces_base,
            'role_name' => $this->role_name,
            'tenant_id' => $this->tenant_id,
            'url' => $this->url,
            'username' => $this->username,
        ];
    }
}
