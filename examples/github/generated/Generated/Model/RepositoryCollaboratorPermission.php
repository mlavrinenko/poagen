<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryCollaboratorPermission
{
    public function __construct(
        public string $permission,
        public string $role_name,
        public NullableCollaborator $user,
    ) {
    }
}
