<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ApiOverviewDomainsArtifact_attestations
{
    /**
     * @param ?list<string> $services
     */
    public function __construct(
        public ?array $services = null,
        public ?string $trust_domain = null,
    ) {
    }
}
