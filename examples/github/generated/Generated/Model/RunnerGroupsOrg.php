<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RunnerGroupsOrg implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'allows_public_repositories' => ['allows_public_repositories', null],
        'default' => ['default', null],
        'id' => ['id', null],
        'inherited' => ['inherited', null],
        'name' => ['name', null],
        'runners_url' => ['runners_url', null],
        'visibility' => ['visibility', null],
        'hosted_runners_url' => ['hosted_runners_url', null],
        'inherited_allows_public_repositories' => ['inherited_allows_public_repositories', null],
        'network_configuration_id' => ['network_configuration_id', null],
        'restricted_to_workflows' => ['restricted_to_workflows', null],
        'selected_repositories_url' => ['selected_repositories_url', null],
        'selected_workflows' => ['selected_workflows', ['list', null]],
        'workflow_restrictions_read_only' => ['workflow_restrictions_read_only', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'allows_public_repositories' => $this->allows_public_repositories,
            'default' => $this->default,
            'id' => $this->id,
            'inherited' => $this->inherited,
            'name' => $this->name,
            'runners_url' => $this->runners_url,
            'visibility' => $this->visibility,
            'hosted_runners_url' => $this->hosted_runners_url,
            'inherited_allows_public_repositories' => $this->inherited_allows_public_repositories,
            'network_configuration_id' => $this->network_configuration_id,
            'restricted_to_workflows' => $this->restricted_to_workflows,
            'selected_repositories_url' => $this->selected_repositories_url,
            'selected_workflows' => $this->selected_workflows,
            'workflow_restrictions_read_only' => $this->workflow_restrictions_read_only,
        ];
    }
}
