<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class GlobalAdvisory
{
    /**
     * @param ?list<array<string, mixed>> $credits
     * @param ?list<array<string, mixed>> $cwes
     * @param ?list<array<string, mixed>> $identifiers
     * @param ?list<string> $references
     * @param ?list<\Acme\GitHub\Generated\Model\Vulnerability> $vulnerabilities
     */
    public function __construct(
        public ?array $credits = null,
        public ?string $cve_id = null,
        public GlobalAdvisoryCvss $cvss,
        public ?array $cwes = null,
        public ?string $description = null,
        public string $ghsa_id,
        public ?DateTimeImmutable $github_reviewed_at = null,
        public string $html_url,
        public ?array $identifiers = null,
        public ?DateTimeImmutable $nvd_published_at = null,
        public DateTimeImmutable $published_at,
        public ?array $references = null,
        public ?string $repository_advisory_url = null,
        public string $severity,
        public ?string $source_code_location = null,
        public string $summary,
        public string $type,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?array $vulnerabilities = null,
        public ?DateTimeImmutable $withdrawn_at = null,
        public ?CvssSeverities $cvss_severities = null,
        public ?SecurityAdvisoryEpss $epss = null,
    ) {
    }
}
