<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhooksAnswer implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'author_association' => ['author_association', null],
        'body' => ['body', null],
        'child_comment_count' => ['child_comment_count', null],
        'created_at' => ['created_at', ['datetime', null]],
        'discussion_id' => ['discussion_id', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'node_id' => ['node_id', null],
        'parent_id' => ['parent_id', null],
        'repository_url' => ['repository_url', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'user' => ['user', \Acme\GitHub\Generated\Model\WebhooksAnswerUser::class],
        'reactions' => ['reactions', \Acme\GitHub\Generated\Model\WebhooksAnswerReactions::class],
    ];

    /**
     * @param ?mixed $parent_id
     */
    public function __construct(
        public string $author_association,
        public string $body,
        public int $child_comment_count,
        public DateTimeImmutable $created_at,
        public int $discussion_id,
        public string $html_url,
        public int $id,
        public string $node_id,
        public $parent_id = null,
        public string $repository_url,
        public DateTimeImmutable $updated_at,
        public WebhooksAnswerUser $user,
        public ?WebhooksAnswerReactions $reactions = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'author_association' => $this->author_association,
            'body' => $this->body,
            'child_comment_count' => $this->child_comment_count,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'discussion_id' => $this->discussion_id,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'node_id' => $this->node_id,
            'parent_id' => $this->parent_id,
            'repository_url' => $this->repository_url,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'user' => $this->user,
            'reactions' => $this->reactions,
        ];
    }
}
