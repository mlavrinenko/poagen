<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class RepositoryAdvisory implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'author' => ['author', null],
        'closed_at' => ['closed_at', ['datetime', null]],
        'collaborating_teams' => ['collaborating_teams', ['list', \Acme\GitHub\Generated\Model\Team::class]],
        'collaborating_users' => ['collaborating_users', ['list', \Acme\GitHub\Generated\Model\SimpleUser::class]],
        'created_at' => ['created_at', ['datetime', null]],
        'credits' => ['credits', ['list', null]],
        'credits_detailed' => ['credits_detailed', ['list', \Acme\GitHub\Generated\Model\RepositoryAdvisoryCredit::class]],
        'cve_id' => ['cve_id', null],
        'cvss' => ['cvss', \Acme\GitHub\Generated\Model\RepositoryAdvisoryCvss::class],
        'cwe_ids' => ['cwe_ids', ['list', null]],
        'cwes' => ['cwes', ['list', null]],
        'description' => ['description', null],
        'ghsa_id' => ['ghsa_id', null],
        'html_url' => ['html_url', null],
        'identifiers' => ['identifiers', ['list', null]],
        'private_fork' => ['private_fork', null],
        'published_at' => ['published_at', ['datetime', null]],
        'publisher' => ['publisher', null],
        'severity' => ['severity', null],
        'state' => ['state', null],
        'submission' => ['submission', \Acme\GitHub\Generated\Model\RepositoryAdvisorySubmission::class],
        'summary' => ['summary', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'vulnerabilities' => [
            'vulnerabilities',
            ['list', \Acme\GitHub\Generated\Model\RepositoryAdvisoryVulnerability::class],
        ],
        'withdrawn_at' => ['withdrawn_at', ['datetime', null]],
        'cvss_severities' => ['cvss_severities', \Acme\GitHub\Generated\Model\CvssSeverities::class],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'author' => $this->author,
            'closed_at' => $this->closed_at?->format(\DateTimeInterface::RFC3339),
            'collaborating_teams' => $this->collaborating_teams,
            'collaborating_users' => $this->collaborating_users,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'credits' => $this->credits,
            'credits_detailed' => $this->credits_detailed,
            'cve_id' => $this->cve_id,
            'cvss' => $this->cvss,
            'cwe_ids' => $this->cwe_ids,
            'cwes' => $this->cwes,
            'description' => $this->description,
            'ghsa_id' => $this->ghsa_id,
            'html_url' => $this->html_url,
            'identifiers' => $this->identifiers,
            'private_fork' => $this->private_fork,
            'published_at' => $this->published_at?->format(\DateTimeInterface::RFC3339),
            'publisher' => $this->publisher,
            'severity' => $this->severity,
            'state' => $this->state,
            'submission' => $this->submission,
            'summary' => $this->summary,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'vulnerabilities' => $this->vulnerabilities,
            'withdrawn_at' => $this->withdrawn_at?->format(\DateTimeInterface::RFC3339),
            'cvss_severities' => $this->cvss_severities,
        ];
    }
}
