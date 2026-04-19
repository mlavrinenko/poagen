<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhookPullRequestReviewDismissedReview implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        '_links' => ['_links', \Acme\GitHub\Generated\Model\WebhookPullRequestReviewDismissedReview_links::class],
        'author_association' => ['author_association', null],
        'body' => ['body', null],
        'commit_id' => ['commit_id', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'node_id' => ['node_id', null],
        'pull_request_url' => ['pull_request_url', null],
        'state' => ['state', null],
        'submitted_at' => ['submitted_at', ['datetime', null]],
        'user' => ['user', \Acme\GitHub\Generated\Model\WebhookPullRequestReviewDismissedReviewUser::class],
        'updated_at' => ['updated_at', ['datetime', null]],
    ];

    public function __construct(
        public WebhookPullRequestReviewDismissedReview_links $_links,
        public string $author_association,
        public ?string $body = null,
        public string $commit_id,
        public string $html_url,
        public int $id,
        public string $node_id,
        public string $pull_request_url,
        public string $state,
        public DateTimeImmutable $submitted_at,
        public WebhookPullRequestReviewDismissedReviewUser $user,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            '_links' => $this->_links,
            'author_association' => $this->author_association,
            'body' => $this->body,
            'commit_id' => $this->commit_id,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'node_id' => $this->node_id,
            'pull_request_url' => $this->pull_request_url,
            'state' => $this->state,
            'submitted_at' => $this->submitted_at->format(\DateTimeInterface::RFC3339),
            'user' => $this->user,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
