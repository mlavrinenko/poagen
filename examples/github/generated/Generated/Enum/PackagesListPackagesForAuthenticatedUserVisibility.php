<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum PackagesListPackagesForAuthenticatedUserVisibility: string
{
    case Public = 'public';
    case Private = 'private';
    case Internal = 'internal';
}
