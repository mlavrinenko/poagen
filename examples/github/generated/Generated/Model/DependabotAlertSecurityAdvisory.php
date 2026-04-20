<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class DependabotAlertSecurityAdvisory
{
    /**
     * @param list<array<string, mixed>> $cwes
     * @param list<array<string, mixed>> $identifiers
     * @param list<array<string, mixed>> $references
     * @param list<\Acme\GitHub\Generated\Model\DependabotAlertSecurityVulnerability> $vulnerabilities
     */
    public function __construct(
        public ?string $cve_id = null,
        public DependabotAlertSecurityAdvisoryCvss $cvss,
        public array $cwes,
        public string $description,
        public string $ghsa_id,
        public array $identifiers,
        public DateTimeImmutable $published_at,
        public array $references,
        public string $severity,
        public string $summary,
        public DateTimeImmutable $updated_at,
        public array $vulnerabilities,
        public ?DateTimeImmutable $withdrawn_at = null,
        public ?string $classification = null,
        public ?CvssSeverities $cvss_severities = null,
        public ?SecurityAdvisoryEpss $epss = null,
    ) {
    }
}
