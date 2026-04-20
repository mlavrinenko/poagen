<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum SecurityAdvisoriesListOrgRepositoryAdvisoriesState: string
{
    case Triage = 'triage';
    case Draft = 'draft';
    case Published = 'published';
    case Closed = 'closed';
}
