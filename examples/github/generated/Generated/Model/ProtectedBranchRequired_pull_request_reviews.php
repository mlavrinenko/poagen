<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ProtectedBranchRequired_pull_request_reviews implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'url' => ['url', null],
        'bypass_pull_request_allowances' => [
            'bypass_pull_request_allowances',
            \Acme\GitHub\Generated\Model\ProtectedBranchRequired_pull_request_reviewsBypass_pull_request_allowances::class,
        ],
        'dismiss_stale_reviews' => ['dismiss_stale_reviews', null],
        'dismissal_restrictions' => [
            'dismissal_restrictions',
            \Acme\GitHub\Generated\Model\ProtectedBranchRequired_pull_request_reviewsDismissal_restrictions::class,
        ],
        'require_code_owner_reviews' => ['require_code_owner_reviews', null],
        'require_last_push_approval' => ['require_last_push_approval', null],
        'required_approving_review_count' => ['required_approving_review_count', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'url' => $this->url,
            'bypass_pull_request_allowances' => $this->bypass_pull_request_allowances,
            'dismiss_stale_reviews' => $this->dismiss_stale_reviews,
            'dismissal_restrictions' => $this->dismissal_restrictions,
            'require_code_owner_reviews' => $this->require_code_owner_reviews,
            'require_last_push_approval' => $this->require_last_push_approval,
            'required_approving_review_count' => $this->required_approving_review_count,
        ];
    }
}
