<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum VpcnatgatewaysListState: string
{
    case New = 'new';
    case Provisioning = 'provisioning';
    case Active = 'active';
    case Deleting = 'deleting';
    case Error = 'error';
    case Invalid = 'invalid';
}
