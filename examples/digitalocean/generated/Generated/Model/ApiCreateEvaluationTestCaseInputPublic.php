<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiCreateEvaluationTestCaseInputPublic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'agent_workspace_name' => ['agent_workspace_name', null],
        'dataset_uuid' => ['dataset_uuid', null],
        'description' => ['description', null],
        'metrics' => ['metrics', ['list', null]],
        'name' => ['name', null],
        'star_metric' => ['star_metric', \Acme\DigitalOcean\Generated\Model\ApiStarMetric::class],
        'workspace_uuid' => ['workspace_uuid', null],
    ];

    /**
     * @param ?list<string> $metrics
     */
    public function __construct(
        public ?string $agent_workspace_name = null,
        public ?string $dataset_uuid = null,
        public ?string $description = null,
        public ?array $metrics = null,
        public ?string $name = null,
        public ?ApiStarMetric $star_metric = null,
        public ?string $workspace_uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'agent_workspace_name' => $this->agent_workspace_name,
            'dataset_uuid' => $this->dataset_uuid,
            'description' => $this->description,
            'metrics' => $this->metrics,
            'name' => $this->name,
            'star_metric' => $this->star_metric,
            'workspace_uuid' => $this->workspace_uuid,
        ];
    }
}
