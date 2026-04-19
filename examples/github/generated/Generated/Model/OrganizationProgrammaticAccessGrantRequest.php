<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class OrganizationProgrammaticAccessGrantRequest implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', null],
        'id' => ['id', null],
        'owner' => ['owner', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'permissions' => [
            'permissions',
            \Acme\GitHub\Generated\Model\OrganizationProgrammaticAccessGrantRequestPermissions::class,
        ],
        'reason' => ['reason', null],
        'repositories_url' => ['repositories_url', null],
        'repository_selection' => ['repository_selection', null],
        'token_expired' => ['token_expired', null],
        'token_expires_at' => ['token_expires_at', null],
        'token_id' => ['token_id', null],
        'token_last_used_at' => ['token_last_used_at', null],
        'token_name' => ['token_name', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at,
            'id' => $this->id,
            'owner' => $this->owner,
            'permissions' => $this->permissions,
            'reason' => $this->reason,
            'repositories_url' => $this->repositories_url,
            'repository_selection' => $this->repository_selection,
            'token_expired' => $this->token_expired,
            'token_expires_at' => $this->token_expires_at,
            'token_id' => $this->token_id,
            'token_last_used_at' => $this->token_last_used_at,
            'token_name' => $this->token_name,
        ];
    }
}
