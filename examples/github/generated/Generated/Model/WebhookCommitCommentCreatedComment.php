<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookCommitCommentCreatedComment
{
    public function __construct(
        public string $author_association,
        public string $body,
        public string $commit_id,
        public string $created_at,
        public string $html_url,
        public int $id,
        public ?int $line = null,
        public string $node_id,
        public ?string $path = null,
        public ?int $position = null,
        public string $updated_at,
        public string $url,
        public WebhookCommitCommentCreatedCommentUser $user,
        public ?WebhookCommitCommentCreatedCommentReactions $reactions = null,
    ) {
    }
}
