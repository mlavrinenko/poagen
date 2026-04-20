<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookInstallationTargetRenamedChanges
{
    public function __construct(
        public ?WebhookInstallationTargetRenamedChangesLogin $login = null,
        public ?WebhookInstallationTargetRenamedChangesSlug $slug = null,
    ) {
    }
}
