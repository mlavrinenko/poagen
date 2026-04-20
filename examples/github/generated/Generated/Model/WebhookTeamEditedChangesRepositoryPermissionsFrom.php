<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookTeamEditedChangesRepositoryPermissionsFrom
{
    public function __construct(
        public ?bool $admin = null,
        public ?bool $pull = null,
        public ?bool $push = null,
    ) {
    }
}
