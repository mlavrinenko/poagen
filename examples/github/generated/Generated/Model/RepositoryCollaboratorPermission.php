<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryCollaboratorPermission implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'permission' => ['permission', null],
        'role_name' => ['role_name', null],
        'user' => ['user', \Acme\GitHub\Generated\Model\NullableCollaborator::class],
    ];

    public function __construct(
        public string $permission,
        public string $role_name,
        public NullableCollaborator $user,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'permission' => $this->permission,
            'role_name' => $this->role_name,
            'user' => $this->user,
        ];
    }
}
