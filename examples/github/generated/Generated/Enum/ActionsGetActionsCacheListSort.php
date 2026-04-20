<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum ActionsGetActionsCacheListSort: string
{
    case CreatedAt = 'created_at';
    case LastAccessedAt = 'last_accessed_at';
    case SizeInBytes = 'size_in_bytes';
}
