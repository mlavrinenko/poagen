<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum AuthorAssociation: string
{
    case Collaborator = 'COLLABORATOR';
    case Contributor = 'CONTRIBUTOR';
    case FirstTimer = 'FIRST_TIMER';
    case FirstTimeContributor = 'FIRST_TIME_CONTRIBUTOR';
    case Mannequin = 'MANNEQUIN';
    case Member = 'MEMBER';
    case None = 'NONE';
    case Owner = 'OWNER';
}
