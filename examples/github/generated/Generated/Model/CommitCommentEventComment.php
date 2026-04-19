<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class CommitCommentEventComment implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'body' => ['body', null],
        'commit_id' => ['commit_id', null],
        'created_at' => ['created_at', ['datetime', null]],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'line' => ['line', null],
        'node_id' => ['node_id', null],
        'path' => ['path', null],
        'position' => ['position', null],
        'reactions' => ['reactions', \Acme\GitHub\Generated\Model\ReactionRollup::class],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'user' => ['user', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
    ];

    public function __construct(
        public ?string $body = null,
        public ?string $commit_id = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $html_url = null,
        public ?int $id = null,
        public ?int $line = null,
        public ?string $node_id = null,
        public ?string $path = null,
        public ?int $position = null,
        public ?ReactionRollup $reactions = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $url = null,
        public ?NullableSimpleUser $user = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'body' => $this->body,
            'commit_id' => $this->commit_id,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'html_url' => $this->html_url,
            'id' => $this->id,
            'line' => $this->line,
            'node_id' => $this->node_id,
            'path' => $this->path,
            'position' => $this->position,
            'reactions' => $this->reactions,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'user' => $this->user,
        ];
    }
}
