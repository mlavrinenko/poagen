<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum PackagesGetPackageVersionForOrganizationPackageType: string
{
    case Npm = 'npm';
    case Maven = 'maven';
    case Rubygems = 'rubygems';
    case Docker = 'docker';
    case Nuget = 'nuget';
    case Container = 'container';
}
