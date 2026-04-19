<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiEvaluationRunStatus;
use DateTimeImmutable;
use JsonSerializable;

final readonly class ApiEvaluationRun implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'agent_deleted' => ['agent_deleted', null],
        'agent_deployment_name' => ['agent_deployment_name', null],
        'agent_name' => ['agent_name', null],
        'agent_uuid' => ['agent_uuid', null],
        'agent_version_hash' => ['agent_version_hash', null],
        'agent_workspace_uuid' => ['agent_workspace_uuid', null],
        'created_by_user_email' => ['created_by_user_email', null],
        'created_by_user_id' => ['created_by_user_id', null],
        'error_description' => ['error_description', null],
        'evaluation_run_uuid' => ['evaluation_run_uuid', null],
        'evaluation_test_case_workspace_uuid' => ['evaluation_test_case_workspace_uuid', null],
        'finished_at' => ['finished_at', ['datetime', null]],
        'pass_status' => ['pass_status', null],
        'queued_at' => ['queued_at', ['datetime', null]],
        'run_level_metric_results' => [
            'run_level_metric_results',
            ['list', \Acme\DigitalOcean\Generated\Model\ApiEvaluationMetricResult::class],
        ],
        'run_name' => ['run_name', null],
        'star_metric_result' => ['star_metric_result', \Acme\DigitalOcean\Generated\Model\ApiEvaluationMetricResult::class],
        'started_at' => ['started_at', ['datetime', null]],
        'status' => ['status', ['enum', \Acme\DigitalOcean\Generated\Enum\ApiEvaluationRunStatus::class]],
        'test_case_description' => ['test_case_description', null],
        'test_case_name' => ['test_case_name', null],
        'test_case_uuid' => ['test_case_uuid', null],
        'test_case_version' => ['test_case_version', null],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiEvaluationMetricResult> $run_level_metric_results
     */
    public function __construct(
        public ?bool $agent_deleted = null,
        public ?string $agent_deployment_name = null,
        public ?string $agent_name = null,
        public ?string $agent_uuid = null,
        public ?string $agent_version_hash = null,
        public ?string $agent_workspace_uuid = null,
        public ?string $created_by_user_email = null,
        public ?string $created_by_user_id = null,
        public ?string $error_description = null,
        public ?string $evaluation_run_uuid = null,
        public ?string $evaluation_test_case_workspace_uuid = null,
        public ?DateTimeImmutable $finished_at = null,
        public ?bool $pass_status = null,
        public ?DateTimeImmutable $queued_at = null,
        public ?array $run_level_metric_results = null,
        public ?string $run_name = null,
        public ?ApiEvaluationMetricResult $star_metric_result = null,
        public ?DateTimeImmutable $started_at = null,
        public ?ApiEvaluationRunStatus $status = null,
        public ?string $test_case_description = null,
        public ?string $test_case_name = null,
        public ?string $test_case_uuid = null,
        public ?int $test_case_version = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'agent_deleted' => $this->agent_deleted,
            'agent_deployment_name' => $this->agent_deployment_name,
            'agent_name' => $this->agent_name,
            'agent_uuid' => $this->agent_uuid,
            'agent_version_hash' => $this->agent_version_hash,
            'agent_workspace_uuid' => $this->agent_workspace_uuid,
            'created_by_user_email' => $this->created_by_user_email,
            'created_by_user_id' => $this->created_by_user_id,
            'error_description' => $this->error_description,
            'evaluation_run_uuid' => $this->evaluation_run_uuid,
            'evaluation_test_case_workspace_uuid' => $this->evaluation_test_case_workspace_uuid,
            'finished_at' => $this->finished_at?->format(\DateTimeInterface::RFC3339),
            'pass_status' => $this->pass_status,
            'queued_at' => $this->queued_at?->format(\DateTimeInterface::RFC3339),
            'run_level_metric_results' => $this->run_level_metric_results,
            'run_name' => $this->run_name,
            'star_metric_result' => $this->star_metric_result,
            'started_at' => $this->started_at?->format(\DateTimeInterface::RFC3339),
            'status' => $this->status,
            'test_case_description' => $this->test_case_description,
            'test_case_name' => $this->test_case_name,
            'test_case_uuid' => $this->test_case_uuid,
            'test_case_version' => $this->test_case_version,
        ];
    }
}
