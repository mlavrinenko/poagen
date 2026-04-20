<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PersonalAccessTokenRequest
{
    /**
     * @param ?list<array<string, mixed>> $repositories
     */
    public function __construct(
        public string $created_at,
        public int $id,
        public SimpleUser $owner,
        public PersonalAccessTokenRequestPermissions_added $permissions_added,
        public PersonalAccessTokenRequestPermissions_result $permissions_result,
        public PersonalAccessTokenRequestPermissions_upgraded $permissions_upgraded,
        public ?array $repositories = null,
        public ?int $repository_count = null,
        public string $repository_selection,
        public bool $token_expired,
        public ?string $token_expires_at = null,
        public int $token_id,
        public ?string $token_last_used_at = null,
        public string $token_name,
    ) {
    }
}
