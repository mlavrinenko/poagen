<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum PackagesListPackagesForUserVisibility: string
{
    case Public = 'public';
    case Private = 'private';
    case Internal = 'internal';
}
