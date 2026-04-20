<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookSecurityAdvisoryWithdrawnSecurity_advisory
{
    /**
     * @param list<array<string, mixed>> $cwes
     * @param list<array<string, mixed>> $identifiers
     * @param list<array<string, mixed>> $references
     * @param list<array<string, mixed>> $vulnerabilities
     */
    public function __construct(
        public WebhookSecurityAdvisoryWithdrawnSecurity_advisoryCvss $cvss,
        public array $cwes,
        public string $description,
        public string $ghsa_id,
        public array $identifiers,
        public string $published_at,
        public array $references,
        public string $severity,
        public string $summary,
        public string $updated_at,
        public array $vulnerabilities,
        public string $withdrawn_at,
        public ?CvssSeverities $cvss_severities = null,
    ) {
    }
}
