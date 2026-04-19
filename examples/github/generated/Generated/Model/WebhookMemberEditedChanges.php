<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookMemberEditedChanges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'old_permission' => [
            'old_permission',
            \Acme\GitHub\Generated\Model\WebhookMemberEditedChangesOld_permission::class,
        ],
        'permission' => ['permission', \Acme\GitHub\Generated\Model\WebhookMemberEditedChangesPermission::class],
    ];

    public function __construct(
        public ?WebhookMemberEditedChangesOld_permission $old_permission = null,
        public ?WebhookMemberEditedChangesPermission $permission = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'old_permission' => $this->old_permission,
            'permission' => $this->permission,
        ];
    }
}
