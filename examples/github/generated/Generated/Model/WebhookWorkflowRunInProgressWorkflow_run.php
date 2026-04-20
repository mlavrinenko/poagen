<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookWorkflowRunInProgressWorkflow_run
{
    /**
     * @param list<array<string, mixed>> $pull_requests
     * @param ?list<array<string, mixed>> $referenced_workflows
     */
    public function __construct(
        public WebhookWorkflowRunInProgressWorkflow_runActor $actor,
        public string $artifacts_url,
        public string $cancel_url,
        public int $check_suite_id,
        public string $check_suite_node_id,
        public string $check_suite_url,
        public ?string $conclusion = null,
        public DateTimeImmutable $created_at,
        public string $event,
        public ?string $head_branch = null,
        public WebhookWorkflowRunInProgressWorkflow_runHead_commit $head_commit,
        public WebhookWorkflowRunInProgressWorkflow_runHead_repository $head_repository,
        public string $head_sha,
        public string $html_url,
        public int $id,
        public string $jobs_url,
        public string $logs_url,
        public ?string $name = null,
        public string $node_id,
        public string $path,
        public ?string $previous_attempt_url = null,
        public array $pull_requests,
        public WebhookWorkflowRunInProgressWorkflow_runRepository $repository,
        public string $rerun_url,
        public int $run_attempt,
        public int $run_number,
        public DateTimeImmutable $run_started_at,
        public string $status,
        public WebhookWorkflowRunInProgressWorkflow_runTriggering_actor $triggering_actor,
        public DateTimeImmutable $updated_at,
        public string $url,
        public int $workflow_id,
        public string $workflow_url,
        public ?array $referenced_workflows = null,
    ) {
    }
}
