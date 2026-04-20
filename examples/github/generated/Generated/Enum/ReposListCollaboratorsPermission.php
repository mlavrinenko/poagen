<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum ReposListCollaboratorsPermission: string
{
    case Pull = 'pull';
    case Triage = 'triage';
    case Push = 'push';
    case Maintain = 'maintain';
    case Admin = 'admin';
}
