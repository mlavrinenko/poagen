<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum ApiDeploymentStatus: string
{
    case StatusUnknown = 'STATUS_UNKNOWN';
    case StatusWaitingForDeployment = 'STATUS_WAITING_FOR_DEPLOYMENT';
    case StatusDeploying = 'STATUS_DEPLOYING';
    case StatusRunning = 'STATUS_RUNNING';
    case StatusFailed = 'STATUS_FAILED';
    case StatusWaitingForUndeployment = 'STATUS_WAITING_FOR_UNDEPLOYMENT';
    case StatusUndeploying = 'STATUS_UNDEPLOYING';
    case StatusUndeploymentFailed = 'STATUS_UNDEPLOYMENT_FAILED';
    case StatusDeleted = 'STATUS_DELETED';
    case StatusBuilding = 'STATUS_BUILDING';
}
