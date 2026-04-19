<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhookPullRequestReviewCommentDeletedPull_requestMilestone implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'closed_at' => ['closed_at', ['datetime', null]],
        'closed_issues' => ['closed_issues', null],
        'created_at' => ['created_at', ['datetime', null]],
        'creator' => [
            'creator',
            \Acme\GitHub\Generated\Model\WebhookPullRequestReviewCommentDeletedPull_requestMilestoneCreator::class,
        ],
        'description' => ['description', null],
        'due_on' => ['due_on', ['datetime', null]],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'labels_url' => ['labels_url', null],
        'node_id' => ['node_id', null],
        'number' => ['number', null],
        'open_issues' => ['open_issues', null],
        'state' => ['state', null],
        'title' => ['title', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
    ];

    public function __construct(
        public ?DateTimeImmutable $closed_at = null,
        public int $closed_issues,
        public DateTimeImmutable $created_at,
        public WebhookPullRequestReviewCommentDeletedPull_requestMilestoneCreator $creator,
        public ?string $description = null,
        public ?DateTimeImmutable $due_on = null,
        public string $html_url,
        public int $id,
        public string $labels_url,
        public string $node_id,
        public int $number,
        public int $open_issues,
        public string $state,
        public string $title,
        public DateTimeImmutable $updated_at,
        public string $url,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'closed_at' => $this->closed_at?->format(\DateTimeInterface::RFC3339),
            'closed_issues' => $this->closed_issues,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'creator' => $this->creator,
            'description' => $this->description,
            'due_on' => $this->due_on?->format(\DateTimeInterface::RFC3339),
            'html_url' => $this->html_url,
            'id' => $this->id,
            'labels_url' => $this->labels_url,
            'node_id' => $this->node_id,
            'number' => $this->number,
            'open_issues' => $this->open_issues,
            'state' => $this->state,
            'title' => $this->title,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
        ];
    }
}
