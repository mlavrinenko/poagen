<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookCommitCommentCreatedComment implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'author_association' => ['author_association', null],
        'body' => ['body', null],
        'commit_id' => ['commit_id', null],
        'created_at' => ['created_at', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'line' => ['line', null],
        'node_id' => ['node_id', null],
        'path' => ['path', null],
        'position' => ['position', null],
        'updated_at' => ['updated_at', null],
        'url' => ['url', null],
        'user' => ['user', \Acme\GitHub\Generated\Model\WebhookCommitCommentCreatedCommentUser::class],
        'reactions' => ['reactions', \Acme\GitHub\Generated\Model\WebhookCommitCommentCreatedCommentReactions::class],
    ];

    public function __construct(
        public string $author_association,
        public string $body,
        public string $commit_id,
        public string $created_at,
        public string $html_url,
        public int $id,
        public ?int $line = null,
        public string $node_id,
        public ?string $path = null,
        public ?int $position = null,
        public string $updated_at,
        public string $url,
        public WebhookCommitCommentCreatedCommentUser $user,
        public ?WebhookCommitCommentCreatedCommentReactions $reactions = null,
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
            'commit_id' => $this->commit_id,
            'created_at' => $this->created_at,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'line' => $this->line,
            'node_id' => $this->node_id,
            'path' => $this->path,
            'position' => $this->position,
            'updated_at' => $this->updated_at,
            'url' => $this->url,
            'user' => $this->user,
            'reactions' => $this->reactions,
        ];
    }
}
