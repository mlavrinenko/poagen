<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryRulePullRequestParameters implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'dismiss_stale_reviews_on_push' => ['dismiss_stale_reviews_on_push', null],
        'require_code_owner_review' => ['require_code_owner_review', null],
        'require_last_push_approval' => ['require_last_push_approval', null],
        'required_approving_review_count' => ['required_approving_review_count', null],
        'required_review_thread_resolution' => ['required_review_thread_resolution', null],
        'allowed_merge_methods' => ['allowed_merge_methods', ['list', null]],
        'required_reviewers' => [
            'required_reviewers',
            ['list', \Acme\GitHub\Generated\Model\RepositoryRuleParamsRequiredReviewerConfiguration::class],
        ],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'dismiss_stale_reviews_on_push' => $this->dismiss_stale_reviews_on_push,
            'require_code_owner_review' => $this->require_code_owner_review,
            'require_last_push_approval' => $this->require_last_push_approval,
            'required_approving_review_count' => $this->required_approving_review_count,
            'required_review_thread_resolution' => $this->required_review_thread_resolution,
            'allowed_merge_methods' => $this->allowed_merge_methods,
            'required_reviewers' => $this->required_reviewers,
        ];
    }
}
