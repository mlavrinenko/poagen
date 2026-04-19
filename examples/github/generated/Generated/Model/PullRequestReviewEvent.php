<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class PullRequestReviewEvent implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'pull_request' => ['pull_request', \Acme\GitHub\Generated\Model\PullRequestMinimal::class],
        'review' => ['review', \Acme\GitHub\Generated\Model\PullRequestReviewEventReview::class],
    ];

    public function __construct(
        public string $action,
        public PullRequestMinimal $pull_request,
        public PullRequestReviewEventReview $review,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'action' => $this->action,
            'pull_request' => $this->pull_request,
            'review' => $this->review,
        ];
    }
}
