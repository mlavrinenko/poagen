<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ProtectedBranchPullRequestReview
{
    public function __construct(
        public bool $dismiss_stale_reviews,
        public bool $require_code_owner_reviews,
        public ?ProtectedBranchPullRequestReviewBypass_pull_request_allowances $bypass_pull_request_allowances = null,
        public ?ProtectedBranchPullRequestReviewDismissal_restrictions $dismissal_restrictions = null,
        public ?bool $require_last_push_approval = null,
        public ?int $required_approving_review_count = null,
        public ?string $url = null,
    ) {
    }
}
