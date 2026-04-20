<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryAdvisoryUpdate
{
    /**
     * @param ?list<string> $collaborating_teams
     * @param ?list<string> $collaborating_users
     * @param ?list<array<string, mixed>> $credits
     * @param ?list<string> $cwe_ids
     * @param ?list<array<string, mixed>> $vulnerabilities
     */
    public function __construct(
        public ?array $collaborating_teams = null,
        public ?array $collaborating_users = null,
        public ?array $credits = null,
        public ?string $cve_id = null,
        public ?string $cvss_vector_string = null,
        public ?array $cwe_ids = null,
        public ?string $description = null,
        public ?string $severity = null,
        public ?string $state = null,
        public ?string $summary = null,
        public ?array $vulnerabilities = null,
    ) {
    }
}
