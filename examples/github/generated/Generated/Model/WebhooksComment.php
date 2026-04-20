<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhooksComment
{
    public function __construct(
        public string $author_association,
        public string $body,
        public int $child_comment_count,
        public string $created_at,
        public int $discussion_id,
        public string $html_url,
        public int $id,
        public string $node_id,
        public ?int $parent_id = null,
        public WebhooksCommentReactions $reactions,
        public string $repository_url,
        public string $updated_at,
        public WebhooksCommentUser $user,
    ) {
    }
}
