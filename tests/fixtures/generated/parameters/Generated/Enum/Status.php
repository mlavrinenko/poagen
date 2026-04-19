<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated\Enum;

enum Status: string
{
    case Placed = 'placed';
    case Approved = 'approved';
    case Delivered = 'delivered';
}
