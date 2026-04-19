<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryAdvisoryUpdate implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'collaborating_teams' => ['collaborating_teams', ['list', null]],
        'collaborating_users' => ['collaborating_users', ['list', null]],
        'credits' => ['credits', ['list', null]],
        'cve_id' => ['cve_id', null],
        'cvss_vector_string' => ['cvss_vector_string', null],
        'cwe_ids' => ['cwe_ids', ['list', null]],
        'description' => ['description', null],
        'severity' => ['severity', null],
        'state' => ['state', null],
        'summary' => ['summary', null],
        'vulnerabilities' => ['vulnerabilities', ['list', null]],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'collaborating_teams' => $this->collaborating_teams,
            'collaborating_users' => $this->collaborating_users,
            'credits' => $this->credits,
            'cve_id' => $this->cve_id,
            'cvss_vector_string' => $this->cvss_vector_string,
            'cwe_ids' => $this->cwe_ids,
            'description' => $this->description,
            'severity' => $this->severity,
            'state' => $this->state,
            'summary' => $this->summary,
            'vulnerabilities' => $this->vulnerabilities,
        ];
    }
}
