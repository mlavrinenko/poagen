<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class OrganizationProgrammaticAccessGrantRequest
{
    public function __construct(
        public string $created_at,
        public int $id,
        public SimpleUser $owner,
        public OrganizationProgrammaticAccessGrantRequestPermissions $permissions,
        public ?string $reason = null,
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
