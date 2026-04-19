<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiEvaluationMetricCategory;
use Acme\DigitalOcean\Generated\Enum\ApiEvaluationMetricType;
use Acme\DigitalOcean\Generated\Enum\ApiEvaluationMetricValueType;
use JsonSerializable;

final readonly class ApiEvaluationMetric implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'category' => ['category', ['enum', \Acme\DigitalOcean\Generated\Enum\ApiEvaluationMetricCategory::class]],
        'description' => ['description', null],
        'inverted' => ['inverted', null],
        'is_metric_goal' => ['is_metric_goal', null],
        'metric_name' => ['metric_name', null],
        'metric_rank' => ['metric_rank', null],
        'metric_type' => ['metric_type', ['enum', \Acme\DigitalOcean\Generated\Enum\ApiEvaluationMetricType::class]],
        'metric_uuid' => ['metric_uuid', null],
        'metric_value_type' => [
            'metric_value_type',
            ['enum', \Acme\DigitalOcean\Generated\Enum\ApiEvaluationMetricValueType::class],
        ],
        'range_max' => ['range_max', null],
        'range_min' => ['range_min', null],
    ];

    public function __construct(
        public ?ApiEvaluationMetricCategory $category = null,
        public ?string $description = null,
        public ?bool $inverted = null,
        public ?bool $is_metric_goal = null,
        public ?string $metric_name = null,
        public ?int $metric_rank = null,
        public ?ApiEvaluationMetricType $metric_type = null,
        public ?string $metric_uuid = null,
        public ?ApiEvaluationMetricValueType $metric_value_type = null,
        public ?float $range_max = null,
        public ?float $range_min = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'category' => $this->category,
            'description' => $this->description,
            'inverted' => $this->inverted,
            'is_metric_goal' => $this->is_metric_goal,
            'metric_name' => $this->metric_name,
            'metric_rank' => $this->metric_rank,
            'metric_type' => $this->metric_type,
            'metric_uuid' => $this->metric_uuid,
            'metric_value_type' => $this->metric_value_type,
            'range_max' => $this->range_max,
            'range_min' => $this->range_min,
        ];
    }
}
