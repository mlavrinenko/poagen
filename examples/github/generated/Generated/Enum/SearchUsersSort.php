<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum SearchUsersSort: string
{
    case Followers = 'followers';
    case Repositories = 'repositories';
    case Joined = 'joined';
}
