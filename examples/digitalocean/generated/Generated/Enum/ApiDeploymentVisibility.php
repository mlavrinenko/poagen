<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum ApiDeploymentVisibility: string
{
    case VisibilityUnknown = 'VISIBILITY_UNKNOWN';
    case VisibilityDisabled = 'VISIBILITY_DISABLED';
    case VisibilityPlayground = 'VISIBILITY_PLAYGROUND';
    case VisibilityPublic = 'VISIBILITY_PUBLIC';
    case VisibilityPrivate = 'VISIBILITY_PRIVATE';
}
