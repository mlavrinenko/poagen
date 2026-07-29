<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Enum;

enum OrderStatus: string
{
    case Placed = 'placed';
    case Approved = 'approved';
    case Delivered = 'delivered';
}
