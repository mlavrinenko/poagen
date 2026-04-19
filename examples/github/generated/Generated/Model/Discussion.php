<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Discussion implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'active_lock_reason' => ['active_lock_reason', null],
        'answer_chosen_at' => ['answer_chosen_at', null],
        'answer_chosen_by' => ['answer_chosen_by', \Acme\GitHub\Generated\Model\DiscussionAnswer_chosen_by::class],
        'answer_html_url' => ['answer_html_url', null],
        'body' => ['body', null],
        'category' => ['category', \Acme\GitHub\Generated\Model\DiscussionCategory::class],
        'comments' => ['comments', null],
        'created_at' => ['created_at', ['datetime', null]],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'locked' => ['locked', null],
        'node_id' => ['node_id', null],
        'number' => ['number', null],
        'repository_url' => ['repository_url', null],
        'state' => ['state', null],
        'state_reason' => ['state_reason', null],
        'title' => ['title', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'user' => ['user', \Acme\GitHub\Generated\Model\DiscussionUser::class],
        'author_association' => ['author_association', null],
        'labels' => ['labels', ['list', \Acme\GitHub\Generated\Model\Label::class]],
        'reactions' => ['reactions', \Acme\GitHub\Generated\Model\DiscussionReactions::class],
        'timeline_url' => ['timeline_url', null],
    ];

    /**
     * @param ?list<\Acme\GitHub\Generated\Model\Label> $labels
     */
    public function __construct(
        public ?string $active_lock_reason = null,
        public ?string $answer_chosen_at = null,
        public DiscussionAnswer_chosen_by $answer_chosen_by,
        public ?string $answer_html_url = null,
        public string $body,
        public DiscussionCategory $category,
        public int $comments,
        public DateTimeImmutable $created_at,
        public string $html_url,
        public int $id,
        public bool $locked,
        public string $node_id,
        public int $number,
        public string $repository_url,
        public string $state,
        public ?string $state_reason = null,
        public string $title,
        public DateTimeImmutable $updated_at,
        public DiscussionUser $user,
        public ?string $author_association = null,
        public ?array $labels = null,
        public ?DiscussionReactions $reactions = null,
        public ?string $timeline_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'active_lock_reason' => $this->active_lock_reason,
            'answer_chosen_at' => $this->answer_chosen_at,
            'answer_chosen_by' => $this->answer_chosen_by,
            'answer_html_url' => $this->answer_html_url,
            'body' => $this->body,
            'category' => $this->category,
            'comments' => $this->comments,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'html_url' => $this->html_url,
            'id' => $this->id,
            'locked' => $this->locked,
            'node_id' => $this->node_id,
            'number' => $this->number,
            'repository_url' => $this->repository_url,
            'state' => $this->state,
            'state_reason' => $this->state_reason,
            'title' => $this->title,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'user' => $this->user,
            'author_association' => $this->author_association,
            'labels' => $this->labels,
            'reactions' => $this->reactions,
            'timeline_url' => $this->timeline_url,
        ];
    }
}
