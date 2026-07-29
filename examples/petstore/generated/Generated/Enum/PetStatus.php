<?php

declare(strict_types=1);

namespace Acme\Petstore\Generated\Enum;

enum PetStatus: string
{
    case Available = 'available';
    case Pending = 'pending';
    case Sold = 'sold';
}
