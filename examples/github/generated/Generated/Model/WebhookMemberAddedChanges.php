<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookMemberAddedChanges
{
    public function __construct(
        public ?WebhookMemberAddedChangesPermission $permission = null,
        public ?WebhookMemberAddedChangesRole_name $role_name = null,
    ) {
    }
}
