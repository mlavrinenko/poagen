<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ApiOverviewDomains
{
    /**
     * @param ?list<string> $actions
     * @param ?list<string> $codespaces
     * @param ?list<string> $copilot
     * @param ?list<string> $packages
     * @param ?list<string> $website
     */
    public function __construct(
        public ?array $actions = null,
        public ?ApiOverviewDomainsActions_inbound $actions_inbound = null,
        public ?ApiOverviewDomainsArtifact_attestations $artifact_attestations = null,
        public ?array $codespaces = null,
        public ?array $copilot = null,
        public ?array $packages = null,
        public ?array $website = null,
    ) {
    }
}
