<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookRepositoryTransferredChangesOwnerFrom
{
    public function __construct(
        public ?WebhookRepositoryTransferredChangesOwnerFromOrganization $organization = null,
        public ?WebhookRepositoryTransferredChangesOwnerFromUser $user = null,
    ) {
    }
}
