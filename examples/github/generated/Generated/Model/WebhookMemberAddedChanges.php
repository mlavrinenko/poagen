<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookMemberAddedChanges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'permission' => ['permission', \Acme\GitHub\Generated\Model\WebhookMemberAddedChangesPermission::class],
        'role_name' => ['role_name', \Acme\GitHub\Generated\Model\WebhookMemberAddedChangesRole_name::class],
    ];

    public function __construct(
        public ?WebhookMemberAddedChangesPermission $permission = null,
        public ?WebhookMemberAddedChangesRole_name $role_name = null,
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
        ];
    }
}
