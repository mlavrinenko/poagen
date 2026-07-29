<?php

declare(strict_types=1);

namespace Acme\Petstore\Generated\Enum;

enum OrderStatus: string
{
    case Placed = 'placed';
    case Approved = 'approved';
    case Delivered = 'delivered';
}
