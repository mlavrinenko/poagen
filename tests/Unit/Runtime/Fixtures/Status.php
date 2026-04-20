<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures;

enum Status: string
{
    case Placed = 'placed';
    case Approved = 'approved';
    case Delivered = 'delivered';
}
