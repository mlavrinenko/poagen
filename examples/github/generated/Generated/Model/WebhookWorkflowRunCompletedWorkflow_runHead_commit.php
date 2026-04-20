<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookWorkflowRunCompletedWorkflow_runHead_commit
{
    public function __construct(
        public WebhookWorkflowRunCompletedWorkflow_runHead_commitAuthor $author,
        public WebhookWorkflowRunCompletedWorkflow_runHead_commitCommitter $committer,
        public string $id,
        public string $message,
        public string $timestamp,
        public string $tree_id,
    ) {
    }
}
