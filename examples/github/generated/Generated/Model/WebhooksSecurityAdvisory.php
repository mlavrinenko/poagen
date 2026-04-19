<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhooksSecurityAdvisory implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'cvss' => ['cvss', \Acme\GitHub\Generated\Model\WebhooksSecurityAdvisoryCvss::class],
        'cwes' => ['cwes', ['list', null]],
        'description' => ['description', null],
        'ghsa_id' => ['ghsa_id', null],
        'identifiers' => ['identifiers', ['list', null]],
        'published_at' => ['published_at', null],
        'references' => ['references', ['list', null]],
        'severity' => ['severity', null],
        'summary' => ['summary', null],
        'updated_at' => ['updated_at', null],
        'vulnerabilities' => ['vulnerabilities', ['list', null]],
        'withdrawn_at' => ['withdrawn_at', null],
        'cvss_severities' => ['cvss_severities', \Acme\GitHub\Generated\Model\CvssSeverities::class],
    ];

    /**
     * @param list<array<string, mixed>> $cwes
     * @param list<array<string, mixed>> $identifiers
     * @param list<array<string, mixed>> $references
     * @param list<array<string, mixed>> $vulnerabilities
     */
    public function __construct(
        public WebhooksSecurityAdvisoryCvss $cvss,
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
        public ?string $withdrawn_at = null,
        public ?CvssSeverities $cvss_severities = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'cvss' => $this->cvss,
            'cwes' => $this->cwes,
            'description' => $this->description,
            'ghsa_id' => $this->ghsa_id,
            'identifiers' => $this->identifiers,
            'published_at' => $this->published_at,
            'references' => $this->references,
            'severity' => $this->severity,
            'summary' => $this->summary,
            'updated_at' => $this->updated_at,
            'vulnerabilities' => $this->vulnerabilities,
            'withdrawn_at' => $this->withdrawn_at,
            'cvss_severities' => $this->cvss_severities,
        ];
    }
}
