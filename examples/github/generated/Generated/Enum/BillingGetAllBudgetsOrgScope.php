<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum BillingGetAllBudgetsOrgScope: string
{
    case Enterprise = 'enterprise';
    case Organization = 'organization';
    case Repository = 'repository';
    case CostCenter = 'cost_center';
}
