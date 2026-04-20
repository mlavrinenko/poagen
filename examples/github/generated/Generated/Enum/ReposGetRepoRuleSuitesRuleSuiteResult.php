<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum ReposGetRepoRuleSuitesRuleSuiteResult: string
{
    case Pass = 'pass';
    case Fail = 'fail';
    case Bypass = 'bypass';
    case All = 'all';
}
