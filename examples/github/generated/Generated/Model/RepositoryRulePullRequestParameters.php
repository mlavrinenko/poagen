<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRulePullRequestParameters
{
    /**
     * @param ?list<string> $allowed_merge_methods
     * @param ?list<\Acme\GitHub\Generated\Model\RepositoryRuleParamsRequiredReviewerConfiguration> $required_reviewers
     */
    public function __construct(
        public bool $dismiss_stale_reviews_on_push,
        public bool $require_code_owner_review,
        public bool $require_last_push_approval,
        public int $required_approving_review_count,
        public bool $required_review_thread_resolution,
        public ?array $allowed_merge_methods = null,
        public ?array $required_reviewers = null,
    ) {
    }
}
