<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum OneClicksListType: string
{
    case Droplet = 'droplet';
    case Kubernetes = 'kubernetes';
}
