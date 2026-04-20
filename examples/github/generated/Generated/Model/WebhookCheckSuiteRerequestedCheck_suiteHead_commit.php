<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookCheckSuiteRerequestedCheck_suiteHead_commit
{
    public function __construct(
        public WebhookCheckSuiteRerequestedCheck_suiteHead_commitAuthor $author,
        public WebhookCheckSuiteRerequestedCheck_suiteHead_commitCommitter $committer,
        public string $id,
        public string $message,
        public string $timestamp,
        public string $tree_id,
    ) {
    }
}
