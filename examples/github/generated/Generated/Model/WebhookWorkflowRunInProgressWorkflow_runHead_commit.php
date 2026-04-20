<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookWorkflowRunInProgressWorkflow_runHead_commit
{
    public function __construct(
        public WebhookWorkflowRunInProgressWorkflow_runHead_commitAuthor $author,
        public WebhookWorkflowRunInProgressWorkflow_runHead_commitCommitter $committer,
        public string $id,
        public string $message,
        public string $timestamp,
        public string $tree_id,
    ) {
    }
}
