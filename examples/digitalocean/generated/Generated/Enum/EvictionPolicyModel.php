<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum EvictionPolicyModel: string
{
    case Noeviction = 'noeviction';
    case AllkeysLru = 'allkeys_lru';
    case AllkeysRandom = 'allkeys_random';
    case VolatileLru = 'volatile_lru';
    case VolatileRandom = 'volatile_random';
    case VolatileTtl = 'volatile_ttl';
}
