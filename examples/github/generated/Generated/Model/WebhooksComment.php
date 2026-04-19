<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhooksComment implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'author_association' => ['author_association', null],
        'body' => ['body', null],
        'child_comment_count' => ['child_comment_count', null],
        'created_at' => ['created_at', null],
        'discussion_id' => ['discussion_id', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'node_id' => ['node_id', null],
        'parent_id' => ['parent_id', null],
        'reactions' => ['reactions', \Acme\GitHub\Generated\Model\WebhooksCommentReactions::class],
        'repository_url' => ['repository_url', null],
        'updated_at' => ['updated_at', null],
        'user' => ['user', \Acme\GitHub\Generated\Model\WebhooksCommentUser::class],
    ];

    public function __construct(
        public string $author_association,
        public string $body,
        public int $child_comment_count,
        public string $created_at,
        public int $discussion_id,
        public string $html_url,
        public int $id,
        public string $node_id,
        public ?int $parent_id = null,
        public WebhooksCommentReactions $reactions,
        public string $repository_url,
        public string $updated_at,
        public WebhooksCommentUser $user,
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
            'created_at' => $this->created_at,
            'discussion_id' => $this->discussion_id,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'node_id' => $this->node_id,
            'parent_id' => $this->parent_id,
            'reactions' => $this->reactions,
            'repository_url' => $this->repository_url,
            'updated_at' => $this->updated_at,
            'user' => $this->user,
        ];
    }
}
