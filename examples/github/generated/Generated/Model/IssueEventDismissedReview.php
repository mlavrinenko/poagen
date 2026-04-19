<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class IssueEventDismissedReview implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'dismissal_message' => ['dismissal_message', null],
        'review_id' => ['review_id', null],
        'state' => ['state', null],
        'dismissal_commit_id' => ['dismissal_commit_id', null],
    ];

    public function __construct(
        public ?string $dismissal_message = null,
        public int $review_id,
        public string $state,
        public ?string $dismissal_commit_id = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'dismissal_message' => $this->dismissal_message,
            'review_id' => $this->review_id,
            'state' => $this->state,
            'dismissal_commit_id' => $this->dismissal_commit_id,
        ];
    }
}
