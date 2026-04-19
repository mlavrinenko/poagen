<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class DependabotAlertSecurityAdvisory implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'cve_id' => ['cve_id', null],
        'cvss' => ['cvss', \Acme\GitHub\Generated\Model\DependabotAlertSecurityAdvisoryCvss::class],
        'cwes' => ['cwes', ['list', null]],
        'description' => ['description', null],
        'ghsa_id' => ['ghsa_id', null],
        'identifiers' => ['identifiers', ['list', null]],
        'published_at' => ['published_at', ['datetime', null]],
        'references' => ['references', ['list', null]],
        'severity' => ['severity', null],
        'summary' => ['summary', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'vulnerabilities' => [
            'vulnerabilities',
            ['list', \Acme\GitHub\Generated\Model\DependabotAlertSecurityVulnerability::class],
        ],
        'withdrawn_at' => ['withdrawn_at', ['datetime', null]],
        'classification' => ['classification', null],
        'cvss_severities' => ['cvss_severities', \Acme\GitHub\Generated\Model\CvssSeverities::class],
        'epss' => ['epss', \Acme\GitHub\Generated\Model\SecurityAdvisoryEpss::class],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'cve_id' => $this->cve_id,
            'cvss' => $this->cvss,
            'cwes' => $this->cwes,
            'description' => $this->description,
            'ghsa_id' => $this->ghsa_id,
            'identifiers' => $this->identifiers,
            'published_at' => $this->published_at->format(\DateTimeInterface::RFC3339),
            'references' => $this->references,
            'severity' => $this->severity,
            'summary' => $this->summary,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'vulnerabilities' => $this->vulnerabilities,
            'withdrawn_at' => $this->withdrawn_at?->format(\DateTimeInterface::RFC3339),
            'classification' => $this->classification,
            'cvss_severities' => $this->cvss_severities,
            'epss' => $this->epss,
        ];
    }
}
