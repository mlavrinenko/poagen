<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum ReposListForAuthenticatedUserType: string
{
    case All = 'all';
    case Owner = 'owner';
    case Public = 'public';
    case Private = 'private';
    case Member = 'member';
}
