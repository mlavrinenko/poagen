<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class PullRequestReviewCommentEventComment
{
    public function __construct(
        public PullRequestReviewCommentEventComment_links $_links,
        public string $body,
        public string $commit_id,
        public DateTimeImmutable $created_at,
        public string $diff_hunk,
        public string $html_url,
        public int $id,
        public string $node_id,
        public string $original_commit_id,
        public int $original_position,
        public string $path,
        public ?int $position = null,
        public ?int $pull_request_review_id = null,
        public string $pull_request_url,
        public PullRequestReviewCommentEventCommentReactions $reactions,
        public DateTimeImmutable $updated_at,
        public string $url,
        public PullRequestReviewCommentEventCommentUser $user,
        public ?int $in_reply_to_id = null,
        public ?string $subject_type = null,
    ) {
    }
}
