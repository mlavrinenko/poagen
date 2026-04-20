<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryAdvisoryCreate
{
    /**
     * @param list<array<string, mixed>> $vulnerabilities
     * @param ?list<array<string, mixed>> $credits
     * @param ?list<string> $cwe_ids
     */
    public function __construct(
        public string $description,
        public string $summary,
        public array $vulnerabilities,
        public ?array $credits = null,
        public ?string $cve_id = null,
        public ?string $cvss_vector_string = null,
        public ?array $cwe_ids = null,
        public ?string $severity = null,
        public ?bool $start_private_fork = null,
    ) {
    }
}
