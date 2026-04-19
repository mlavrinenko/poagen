<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiUpdateEvaluationTestCaseInputPublic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'dataset_uuid' => ['dataset_uuid', null],
        'description' => ['description', null],
        'metrics' => ['metrics', \Acme\DigitalOcean\Generated\Model\ApiEvaluationTestCaseMetricList::class],
        'name' => ['name', null],
        'star_metric' => ['star_metric', \Acme\DigitalOcean\Generated\Model\ApiStarMetric::class],
        'test_case_uuid' => ['test_case_uuid', null],
    ];

    public function __construct(
        public ?string $dataset_uuid = null,
        public ?string $description = null,
        public ?ApiEvaluationTestCaseMetricList $metrics = null,
        public ?string $name = null,
        public ?ApiStarMetric $star_metric = null,
        public ?string $test_case_uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'dataset_uuid' => $this->dataset_uuid,
            'description' => $this->description,
            'metrics' => $this->metrics,
            'name' => $this->name,
            'star_metric' => $this->star_metric,
            'test_case_uuid' => $this->test_case_uuid,
        ];
    }
}
