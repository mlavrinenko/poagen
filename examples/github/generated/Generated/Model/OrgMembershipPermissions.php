<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class OrgMembershipPermissions
{
    public function __construct(
        public bool $can_create_repository,
    ) {
    }
}
