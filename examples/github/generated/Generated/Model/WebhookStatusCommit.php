<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookStatusCommit
{
    /**
     * @param list<array<string, mixed>> $parents
     */
    public function __construct(
        public WebhookStatusCommitAuthor $author,
        public string $comments_url,
        public WebhookStatusCommitCommit $commit,
        public WebhookStatusCommitCommitter $committer,
        public string $html_url,
        public string $node_id,
        public array $parents,
        public string $sha,
        public string $url,
    ) {
    }
}
