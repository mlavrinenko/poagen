<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum AppsDeploymentPhase: string
{
    case Unknown = 'UNKNOWN';
    case PendingBuild = 'PENDING_BUILD';
    case Building = 'BUILDING';
    case PendingDeploy = 'PENDING_DEPLOY';
    case Deploying = 'DEPLOYING';
    case Active = 'ACTIVE';
    case Superseded = 'SUPERSEDED';
    case Error = 'ERROR';
    case Canceled = 'CANCELED';
}
