<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum InteractionGroup: string
{
    case ExistingUsers = 'existing_users';
    case ContributorsOnly = 'contributors_only';
    case CollaboratorsOnly = 'collaborators_only';
}
