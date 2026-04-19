<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum SecurityAdvisoryCreditTypes: string
{
    case Analyst = 'analyst';
    case Finder = 'finder';
    case Reporter = 'reporter';
    case Coordinator = 'coordinator';
    case RemediationDeveloper = 'remediation_developer';
    case RemediationReviewer = 'remediation_reviewer';
    case RemediationVerifier = 'remediation_verifier';
    case Tool = 'tool';
    case Sponsor = 'sponsor';
    case Other = 'other';
}
