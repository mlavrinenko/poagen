<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum ReposGetRepoRuleSuitesTimePeriod: string
{
    case Hour = 'hour';
    case Day = 'day';
    case Week = 'week';
    case Month = 'month';
}
