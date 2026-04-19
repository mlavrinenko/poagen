<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class PullRequestReviewCommentEvent implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'comment' => ['comment', \Acme\GitHub\Generated\Model\PullRequestReviewCommentEventComment::class],
        'pull_request' => ['pull_request', \Acme\GitHub\Generated\Model\PullRequestMinimal::class],
    ];

    public function __construct(
        public string $action,
        public PullRequestReviewCommentEventComment $comment,
        public PullRequestMinimal $pull_request,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'action' => $this->action,
            'comment' => $this->comment,
            'pull_request' => $this->pull_request,
        ];
    }
}
