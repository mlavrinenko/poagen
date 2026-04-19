<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryAdvisoryCreate implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'description' => ['description', null],
        'summary' => ['summary', null],
        'vulnerabilities' => ['vulnerabilities', ['list', null]],
        'credits' => ['credits', ['list', null]],
        'cve_id' => ['cve_id', null],
        'cvss_vector_string' => ['cvss_vector_string', null],
        'cwe_ids' => ['cwe_ids', ['list', null]],
        'severity' => ['severity', null],
        'start_private_fork' => ['start_private_fork', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'summary' => $this->summary,
            'vulnerabilities' => $this->vulnerabilities,
            'credits' => $this->credits,
            'cve_id' => $this->cve_id,
            'cvss_vector_string' => $this->cvss_vector_string,
            'cwe_ids' => $this->cwe_ids,
            'severity' => $this->severity,
            'start_private_fork' => $this->start_private_fork,
        ];
    }
}
