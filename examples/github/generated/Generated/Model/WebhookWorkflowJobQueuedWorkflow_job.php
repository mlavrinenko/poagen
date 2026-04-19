<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhookWorkflowJobQueuedWorkflow_job implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'check_run_url' => ['check_run_url', null],
        'completed_at' => ['completed_at', null],
        'conclusion' => ['conclusion', null],
        'created_at' => ['created_at', null],
        'head_branch' => ['head_branch', null],
        'head_sha' => ['head_sha', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'labels' => ['labels', ['list', null]],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'run_attempt' => ['run_attempt', null],
        'run_id' => ['run_id', null],
        'run_url' => ['run_url', null],
        'runner_group_id' => ['runner_group_id', null],
        'runner_group_name' => ['runner_group_name', null],
        'runner_id' => ['runner_id', null],
        'runner_name' => ['runner_name', null],
        'started_at' => ['started_at', ['datetime', null]],
        'status' => ['status', null],
        'steps' => ['steps', ['list', null]],
        'url' => ['url', null],
        'workflow_name' => ['workflow_name', null],
    ];

    /**
     * @param list<string> $labels
     * @param list<array<string, mixed>> $steps
     */
    public function __construct(
        public string $check_run_url,
        public ?string $completed_at = null,
        public ?string $conclusion = null,
        public string $created_at,
        public ?string $head_branch = null,
        public string $head_sha,
        public string $html_url,
        public int $id,
        public array $labels,
        public string $name,
        public string $node_id,
        public int $run_attempt,
        public float $run_id,
        public string $run_url,
        public ?int $runner_group_id = null,
        public ?string $runner_group_name = null,
        public ?int $runner_id = null,
        public ?string $runner_name = null,
        public DateTimeImmutable $started_at,
        public string $status,
        public array $steps,
        public string $url,
        public ?string $workflow_name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'check_run_url' => $this->check_run_url,
            'completed_at' => $this->completed_at,
            'conclusion' => $this->conclusion,
            'created_at' => $this->created_at,
            'head_branch' => $this->head_branch,
            'head_sha' => $this->head_sha,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'labels' => $this->labels,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'run_attempt' => $this->run_attempt,
            'run_id' => $this->run_id,
            'run_url' => $this->run_url,
            'runner_group_id' => $this->runner_group_id,
            'runner_group_name' => $this->runner_group_name,
            'runner_id' => $this->runner_id,
            'runner_name' => $this->runner_name,
            'started_at' => $this->started_at->format(\DateTimeInterface::RFC3339),
            'status' => $this->status,
            'steps' => $this->steps,
            'url' => $this->url,
            'workflow_name' => $this->workflow_name,
        ];
    }
}
