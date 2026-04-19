<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum SnapshotsListResourceType: string
{
    case Droplet = 'droplet';
    case Volume = 'volume';
}
