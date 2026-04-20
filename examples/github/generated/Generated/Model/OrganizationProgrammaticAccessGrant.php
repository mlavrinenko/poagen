<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class OrganizationProgrammaticAccessGrant
{
    public function __construct(
        public string $access_granted_at,
        public int $id,
        public SimpleUser $owner,
        public OrganizationProgrammaticAccessGrantPermissions $permissions,
        public string $repositories_url,
        public string $repository_selection,
        public bool $token_expired,
        public ?string $token_expires_at = null,
        public int $token_id,
        public ?string $token_last_used_at = null,
        public string $token_name,
    ) {
    }
}
