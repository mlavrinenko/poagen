<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum ReposListCollaboratorsAffiliation: string
{
    case Outside = 'outside';
    case Direct = 'direct';
    case All = 'all';
}
