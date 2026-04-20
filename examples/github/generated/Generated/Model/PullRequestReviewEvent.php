<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PullRequestReviewEvent
{
    public function __construct(
        public string $action,
        public PullRequestMinimal $pull_request,
        public PullRequestReviewEventReview $review,
    ) {
    }
}
