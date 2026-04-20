<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookCheckSuiteCompletedCheck_suiteHead_commit
{
    public function __construct(
        public WebhookCheckSuiteCompletedCheck_suiteHead_commitAuthor $author,
        public WebhookCheckSuiteCompletedCheck_suiteHead_commitCommitter $committer,
        public string $id,
        public string $message,
        public string $timestamp,
        public string $tree_id,
    ) {
    }
}
