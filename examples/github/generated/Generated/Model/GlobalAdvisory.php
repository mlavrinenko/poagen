<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class GlobalAdvisory implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'credits' => ['credits', ['list', null]],
        'cve_id' => ['cve_id', null],
        'cvss' => ['cvss', \Acme\GitHub\Generated\Model\GlobalAdvisoryCvss::class],
        'cwes' => ['cwes', ['list', null]],
        'description' => ['description', null],
        'ghsa_id' => ['ghsa_id', null],
        'github_reviewed_at' => ['github_reviewed_at', ['datetime', null]],
        'html_url' => ['html_url', null],
        'identifiers' => ['identifiers', ['list', null]],
        'nvd_published_at' => ['nvd_published_at', ['datetime', null]],
        'published_at' => ['published_at', ['datetime', null]],
        'references' => ['references', ['list', null]],
        'repository_advisory_url' => ['repository_advisory_url', null],
        'severity' => ['severity', null],
        'source_code_location' => ['source_code_location', null],
        'summary' => ['summary', null],
        'type' => ['type', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'vulnerabilities' => ['vulnerabilities', ['list', \Acme\GitHub\Generated\Model\Vulnerability::class]],
        'withdrawn_at' => ['withdrawn_at', ['datetime', null]],
        'cvss_severities' => ['cvss_severities', \Acme\GitHub\Generated\Model\CvssSeverities::class],
        'epss' => ['epss', \Acme\GitHub\Generated\Model\SecurityAdvisoryEpss::class],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'credits' => $this->credits,
            'cve_id' => $this->cve_id,
            'cvss' => $this->cvss,
            'cwes' => $this->cwes,
            'description' => $this->description,
            'ghsa_id' => $this->ghsa_id,
            'github_reviewed_at' => $this->github_reviewed_at?->format(\DateTimeInterface::RFC3339),
            'html_url' => $this->html_url,
            'identifiers' => $this->identifiers,
            'nvd_published_at' => $this->nvd_published_at?->format(\DateTimeInterface::RFC3339),
            'published_at' => $this->published_at->format(\DateTimeInterface::RFC3339),
            'references' => $this->references,
            'repository_advisory_url' => $this->repository_advisory_url,
            'severity' => $this->severity,
            'source_code_location' => $this->source_code_location,
            'summary' => $this->summary,
            'type' => $this->type,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'vulnerabilities' => $this->vulnerabilities,
            'withdrawn_at' => $this->withdrawn_at?->format(\DateTimeInterface::RFC3339),
            'cvss_severities' => $this->cvss_severities,
            'epss' => $this->epss,
        ];
    }
}
