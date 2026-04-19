<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ApiOverviewDomains implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'actions' => ['actions', ['list', null]],
        'actions_inbound' => ['actions_inbound', \Acme\GitHub\Generated\Model\ApiOverviewDomainsActions_inbound::class],
        'artifact_attestations' => [
            'artifact_attestations',
            \Acme\GitHub\Generated\Model\ApiOverviewDomainsArtifact_attestations::class,
        ],
        'codespaces' => ['codespaces', ['list', null]],
        'copilot' => ['copilot', ['list', null]],
        'packages' => ['packages', ['list', null]],
        'website' => ['website', ['list', null]],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'actions' => $this->actions,
            'actions_inbound' => $this->actions_inbound,
            'artifact_attestations' => $this->artifact_attestations,
            'codespaces' => $this->codespaces,
            'copilot' => $this->copilot,
            'packages' => $this->packages,
            'website' => $this->website,
        ];
    }
}
