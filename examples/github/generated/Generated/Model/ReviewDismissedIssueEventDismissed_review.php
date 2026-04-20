<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ReviewDismissedIssueEventDismissed_review
{
    public function __construct(
        public ?string $dismissal_message = null,
        public int $review_id,
        public string $state,
        public ?string $dismissal_commit_id = null,
    ) {
    }
}
