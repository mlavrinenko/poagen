<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryRuleCopilotCodeReviewParameters implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'review_draft_pull_requests' => ['review_draft_pull_requests', null],
        'review_on_push' => ['review_on_push', null],
    ];

    public function __construct(
        public ?bool $review_draft_pull_requests = null,
        public ?bool $review_on_push = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'review_draft_pull_requests' => $this->review_draft_pull_requests,
            'review_on_push' => $this->review_on_push,
        ];
    }
}
