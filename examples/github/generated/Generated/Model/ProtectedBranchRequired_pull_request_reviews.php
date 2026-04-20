<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ProtectedBranchRequired_pull_request_reviews
{
    public function __construct(
        public string $url,
        public ?ProtectedBranchRequired_pull_request_reviewsBypass_pull_request_allowances $bypass_pull_request_allowances = null,
        public ?bool $dismiss_stale_reviews = null,
        public ?ProtectedBranchRequired_pull_request_reviewsDismissal_restrictions $dismissal_restrictions = null,
        public ?bool $require_code_owner_reviews = null,
        public ?bool $require_last_push_approval = null,
        public ?int $required_approving_review_count = null,
    ) {
    }
}
