<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookStatusCommitCommit
{
    /**
     * @param mixed $author
     * @param mixed $committer
     */
    public function __construct(
        public $author,
        public int $comment_count,
        public $committer,
        public string $message,
        public WebhookStatusCommitCommitTree $tree,
        public string $url,
        public WebhookStatusCommitCommitVerification $verification,
    ) {
    }
}
