<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WorkflowRun implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'artifacts_url' => ['artifacts_url', null],
        'cancel_url' => ['cancel_url', null],
        'check_suite_url' => ['check_suite_url', null],
        'conclusion' => ['conclusion', null],
        'created_at' => ['created_at', ['datetime', null]],
        'display_title' => ['display_title', null],
        'event' => ['event', null],
        'head_branch' => ['head_branch', null],
        'head_commit' => ['head_commit', \Acme\GitHub\Generated\Model\NullableSimpleCommit::class],
        'head_repository' => ['head_repository', \Acme\GitHub\Generated\Model\MinimalRepository::class],
        'head_sha' => ['head_sha', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'jobs_url' => ['jobs_url', null],
        'logs_url' => ['logs_url', null],
        'node_id' => ['node_id', null],
        'path' => ['path', null],
        'pull_requests' => ['pull_requests', ['list', \Acme\GitHub\Generated\Model\PullRequestMinimal::class]],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\MinimalRepository::class],
        'rerun_url' => ['rerun_url', null],
        'run_number' => ['run_number', null],
        'status' => ['status', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'workflow_id' => ['workflow_id', null],
        'workflow_url' => ['workflow_url', null],
        'actor' => ['actor', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'check_suite_id' => ['check_suite_id', null],
        'check_suite_node_id' => ['check_suite_node_id', null],
        'head_repository_id' => ['head_repository_id', null],
        'name' => ['name', null],
        'previous_attempt_url' => ['previous_attempt_url', null],
        'referenced_workflows' => [
            'referenced_workflows',
            ['list', \Acme\GitHub\Generated\Model\ReferencedWorkflow::class],
        ],
        'run_attempt' => ['run_attempt', null],
        'run_started_at' => ['run_started_at', ['datetime', null]],
        'triggering_actor' => ['triggering_actor', \Acme\GitHub\Generated\Model\SimpleUser::class],
    ];

    /**
     * @param ?list<\Acme\GitHub\Generated\Model\PullRequestMinimal> $pull_requests
     * @param ?list<\Acme\GitHub\Generated\Model\ReferencedWorkflow> $referenced_workflows
     */
    public function __construct(
        public string $artifacts_url,
        public string $cancel_url,
        public string $check_suite_url,
        public ?string $conclusion = null,
        public DateTimeImmutable $created_at,
        public string $display_title,
        public string $event,
        public ?string $head_branch = null,
        public NullableSimpleCommit $head_commit,
        public MinimalRepository $head_repository,
        public string $head_sha,
        public string $html_url,
        public int $id,
        public string $jobs_url,
        public string $logs_url,
        public string $node_id,
        public string $path,
        public ?array $pull_requests = null,
        public MinimalRepository $repository,
        public string $rerun_url,
        public int $run_number,
        public ?string $status = null,
        public DateTimeImmutable $updated_at,
        public string $url,
        public int $workflow_id,
        public string $workflow_url,
        public ?SimpleUser $actor = null,
        public ?int $check_suite_id = null,
        public ?string $check_suite_node_id = null,
        public ?int $head_repository_id = null,
        public ?string $name = null,
        public ?string $previous_attempt_url = null,
        public ?array $referenced_workflows = null,
        public ?int $run_attempt = null,
        public ?DateTimeImmutable $run_started_at = null,
        public ?SimpleUser $triggering_actor = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'artifacts_url' => $this->artifacts_url,
            'cancel_url' => $this->cancel_url,
            'check_suite_url' => $this->check_suite_url,
            'conclusion' => $this->conclusion,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'display_title' => $this->display_title,
            'event' => $this->event,
            'head_branch' => $this->head_branch,
            'head_commit' => $this->head_commit,
            'head_repository' => $this->head_repository,
            'head_sha' => $this->head_sha,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'jobs_url' => $this->jobs_url,
            'logs_url' => $this->logs_url,
            'node_id' => $this->node_id,
            'path' => $this->path,
            'pull_requests' => $this->pull_requests,
            'repository' => $this->repository,
            'rerun_url' => $this->rerun_url,
            'run_number' => $this->run_number,
            'status' => $this->status,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'workflow_id' => $this->workflow_id,
            'workflow_url' => $this->workflow_url,
            'actor' => $this->actor,
            'check_suite_id' => $this->check_suite_id,
            'check_suite_node_id' => $this->check_suite_node_id,
            'head_repository_id' => $this->head_repository_id,
            'name' => $this->name,
            'previous_attempt_url' => $this->previous_attempt_url,
            'referenced_workflows' => $this->referenced_workflows,
            'run_attempt' => $this->run_attempt,
            'run_started_at' => $this->run_started_at?->format(\DateTimeInterface::RFC3339),
            'triggering_actor' => $this->triggering_actor,
        ];
    }
}
