<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum PullsListSort: string
{
    case Created = 'created';
    case Updated = 'updated';
    case Popularity = 'popularity';
    case LongRunning = 'long-running';
}
