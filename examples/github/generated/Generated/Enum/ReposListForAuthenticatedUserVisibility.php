<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum ReposListForAuthenticatedUserVisibility: string
{
    case All = 'all';
    case Public = 'public';
    case Private = 'private';
}
