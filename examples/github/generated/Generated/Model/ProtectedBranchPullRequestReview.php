<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ProtectedBranchPullRequestReview implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'dismiss_stale_reviews' => ['dismiss_stale_reviews', null],
        'require_code_owner_reviews' => ['require_code_owner_reviews', null],
        'bypass_pull_request_allowances' => [
            'bypass_pull_request_allowances',
            \Acme\GitHub\Generated\Model\ProtectedBranchPullRequestReviewBypass_pull_request_allowances::class,
        ],
        'dismissal_restrictions' => [
            'dismissal_restrictions',
            \Acme\GitHub\Generated\Model\ProtectedBranchPullRequestReviewDismissal_restrictions::class,
        ],
        'require_last_push_approval' => ['require_last_push_approval', null],
        'required_approving_review_count' => ['required_approving_review_count', null],
        'url' => ['url', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'dismiss_stale_reviews' => $this->dismiss_stale_reviews,
            'require_code_owner_reviews' => $this->require_code_owner_reviews,
            'bypass_pull_request_allowances' => $this->bypass_pull_request_allowances,
            'dismissal_restrictions' => $this->dismissal_restrictions,
            'require_last_push_approval' => $this->require_last_push_approval,
            'required_approving_review_count' => $this->required_approving_review_count,
            'url' => $this->url,
        ];
    }
}
