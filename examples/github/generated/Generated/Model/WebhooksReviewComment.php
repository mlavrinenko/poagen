<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhooksReviewComment
{
    public function __construct(
        public WebhooksReviewComment_links $_links,
        public string $author_association,
        public string $body,
        public string $commit_id,
        public DateTimeImmutable $created_at,
        public string $diff_hunk,
        public string $html_url,
        public int $id,
        public ?int $line = null,
        public string $node_id,
        public string $original_commit_id,
        public int $original_line,
        public int $original_position,
        public ?int $original_start_line = null,
        public string $path,
        public ?int $position = null,
        public ?int $pull_request_review_id = null,
        public string $pull_request_url,
        public WebhooksReviewCommentReactions $reactions,
        public string $side,
        public ?int $start_line = null,
        public ?string $start_side = null,
        public DateTimeImmutable $updated_at,
        public string $url,
        public WebhooksReviewCommentUser $user,
        public ?int $in_reply_to_id = null,
        public ?string $subject_type = null,
    ) {
    }
}
