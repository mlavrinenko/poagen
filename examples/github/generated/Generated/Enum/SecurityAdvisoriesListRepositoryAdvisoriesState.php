<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum SecurityAdvisoriesListRepositoryAdvisoriesState: string
{
    case Triage = 'triage';
    case Draft = 'draft';
    case Published = 'published';
    case Closed = 'closed';
}
