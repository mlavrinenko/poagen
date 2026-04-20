<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookDeploymentReviewRejectedWorkflow_run
{
    /**
     * @param list<array<string, mixed>> $pull_requests
     * @param ?array<string, mixed> $head_commit
     * @param ?list<array<string, mixed>> $referenced_workflows
     */
    public function __construct(
        public WebhookDeploymentReviewRejectedWorkflow_runActor $actor,
        public int $check_suite_id,
        public string $check_suite_node_id,
        public ?string $conclusion = null,
        public DateTimeImmutable $created_at,
        public string $display_title,
        public string $event,
        public string $head_branch,
        public string $head_sha,
        public string $html_url,
        public int $id,
        public string $name,
        public string $node_id,
        public string $path,
        public array $pull_requests,
        public int $run_attempt,
        public int $run_number,
        public DateTimeImmutable $run_started_at,
        public string $status,
        public WebhookDeploymentReviewRejectedWorkflow_runTriggering_actor $triggering_actor,
        public DateTimeImmutable $updated_at,
        public string $url,
        public int $workflow_id,
        public ?string $artifacts_url = null,
        public ?string $cancel_url = null,
        public ?string $check_suite_url = null,
        public ?array $head_commit = null,
        public ?WebhookDeploymentReviewRejectedWorkflow_runHead_repository $head_repository = null,
        public ?string $jobs_url = null,
        public ?string $logs_url = null,
        public ?string $previous_attempt_url = null,
        public ?array $referenced_workflows = null,
        public ?WebhookDeploymentReviewRejectedWorkflow_runRepository $repository = null,
        public ?string $rerun_url = null,
        public ?string $workflow_url = null,
    ) {
    }
}
