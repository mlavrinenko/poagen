<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RunnerGroupsOrg
{
    /**
     * @param ?list<string> $selected_workflows
     */
    public function __construct(
        public bool $allows_public_repositories,
        public bool $default,
        public float $id,
        public bool $inherited,
        public string $name,
        public string $runners_url,
        public string $visibility,
        public ?string $hosted_runners_url = null,
        public ?bool $inherited_allows_public_repositories = null,
        public ?string $network_configuration_id = null,
        public ?bool $restricted_to_workflows = null,
        public ?string $selected_repositories_url = null,
        public ?array $selected_workflows = null,
        public ?bool $workflow_restrictions_read_only = null,
    ) {
    }
}
