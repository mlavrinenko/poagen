<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class RepositoryAdvisory
{
    /**
     * @param ?mixed $author
     * @param ?list<\Acme\GitHub\Generated\Model\Team> $collaborating_teams
     * @param ?list<\Acme\GitHub\Generated\Model\SimpleUser> $collaborating_users
     * @param ?list<array<string, mixed>> $credits
     * @param ?list<\Acme\GitHub\Generated\Model\RepositoryAdvisoryCredit> $credits_detailed
     * @param ?list<string> $cwe_ids
     * @param ?list<array<string, mixed>> $cwes
     * @param list<array<string, mixed>> $identifiers
     * @param ?mixed $private_fork
     * @param ?mixed $publisher
     * @param ?list<\Acme\GitHub\Generated\Model\RepositoryAdvisoryVulnerability> $vulnerabilities
     */
    public function __construct(
        public $author = null,
        public ?DateTimeImmutable $closed_at = null,
        public ?array $collaborating_teams = null,
        public ?array $collaborating_users = null,
        public ?DateTimeImmutable $created_at = null,
        public ?array $credits = null,
        public ?array $credits_detailed = null,
        public ?string $cve_id = null,
        public RepositoryAdvisoryCvss $cvss,
        public ?array $cwe_ids = null,
        public ?array $cwes = null,
        public ?string $description = null,
        public string $ghsa_id,
        public string $html_url,
        public array $identifiers,
        public $private_fork = null,
        public ?DateTimeImmutable $published_at = null,
        public $publisher = null,
        public ?string $severity = null,
        public string $state,
        public RepositoryAdvisorySubmission $submission,
        public string $summary,
        public ?DateTimeImmutable $updated_at = null,
        public string $url,
        public ?array $vulnerabilities = null,
        public ?DateTimeImmutable $withdrawn_at = null,
        public ?CvssSeverities $cvss_severities = null,
    ) {
    }
}
