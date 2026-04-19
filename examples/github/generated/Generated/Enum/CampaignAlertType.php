<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum CampaignAlertType: string
{
    case CodeScanning = 'code_scanning';
    case SecretScanning = 'secret_scanning';
}
