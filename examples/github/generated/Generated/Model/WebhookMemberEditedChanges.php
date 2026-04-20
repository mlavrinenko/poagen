<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookMemberEditedChanges
{
    public function __construct(
        public ?WebhookMemberEditedChangesOld_permission $old_permission = null,
        public ?WebhookMemberEditedChangesPermission $permission = null,
    ) {
    }
}
