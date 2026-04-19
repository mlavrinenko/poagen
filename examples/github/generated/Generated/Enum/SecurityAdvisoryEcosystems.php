<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum SecurityAdvisoryEcosystems: string
{
    case Rubygems = 'rubygems';
    case Npm = 'npm';
    case Pip = 'pip';
    case Maven = 'maven';
    case Nuget = 'nuget';
    case Composer = 'composer';
    case Go = 'go';
    case Rust = 'rust';
    case Erlang = 'erlang';
    case Actions = 'actions';
    case Pub = 'pub';
    case Other = 'other';
    case Swift = 'swift';
}
