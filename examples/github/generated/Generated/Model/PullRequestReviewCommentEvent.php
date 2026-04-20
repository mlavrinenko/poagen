<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PullRequestReviewCommentEvent
{
    public function __construct(
        public string $action,
        public PullRequestReviewCommentEventComment $comment,
        public PullRequestMinimal $pull_request,
    ) {
    }
}
