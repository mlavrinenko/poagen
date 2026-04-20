<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookWorkflowJobWaitingWorkflow_job
{
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
}
