<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ApiEvaluationTestCase implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'archived_at' => ['archived_at', ['datetime', null]],
        'created_at' => ['created_at', ['datetime', null]],
        'created_by_user_email' => ['created_by_user_email', null],
        'created_by_user_id' => ['created_by_user_id', null],
        'dataset' => ['dataset', \Acme\DigitalOcean\Generated\Model\ApiEvaluationDataset::class],
        'dataset_name' => ['dataset_name', null],
        'dataset_uuid' => ['dataset_uuid', null],
        'description' => ['description', null],
        'latest_version_number_of_runs' => ['latest_version_number_of_runs', null],
        'metrics' => ['metrics', ['list', \Acme\DigitalOcean\Generated\Model\ApiEvaluationMetric::class]],
        'name' => ['name', null],
        'star_metric' => ['star_metric', \Acme\DigitalOcean\Generated\Model\ApiStarMetric::class],
        'test_case_uuid' => ['test_case_uuid', null],
        'total_runs' => ['total_runs', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'updated_by_user_email' => ['updated_by_user_email', null],
        'updated_by_user_id' => ['updated_by_user_id', null],
        'version' => ['version', null],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiEvaluationMetric> $metrics
     */
    public function __construct(
        public ?DateTimeImmutable $archived_at = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $created_by_user_email = null,
        public ?string $created_by_user_id = null,
        public ?ApiEvaluationDataset $dataset = null,
        public ?string $dataset_name = null,
        public ?string $dataset_uuid = null,
        public ?string $description = null,
        public ?int $latest_version_number_of_runs = null,
        public ?array $metrics = null,
        public ?string $name = null,
        public ?ApiStarMetric $star_metric = null,
        public ?string $test_case_uuid = null,
        public ?int $total_runs = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $updated_by_user_email = null,
        public ?string $updated_by_user_id = null,
        public ?int $version = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'archived_at' => $this->archived_at?->format(\DateTimeInterface::RFC3339),
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'created_by_user_email' => $this->created_by_user_email,
            'created_by_user_id' => $this->created_by_user_id,
            'dataset' => $this->dataset,
            'dataset_name' => $this->dataset_name,
            'dataset_uuid' => $this->dataset_uuid,
            'description' => $this->description,
            'latest_version_number_of_runs' => $this->latest_version_number_of_runs,
            'metrics' => $this->metrics,
            'name' => $this->name,
            'star_metric' => $this->star_metric,
            'test_case_uuid' => $this->test_case_uuid,
            'total_runs' => $this->total_runs,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'updated_by_user_email' => $this->updated_by_user_email,
            'updated_by_user_id' => $this->updated_by_user_id,
            'version' => $this->version,
        ];
    }
}
