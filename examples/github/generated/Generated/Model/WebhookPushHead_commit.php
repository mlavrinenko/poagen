<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhookPushHead_commit implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'author' => ['author', \Acme\GitHub\Generated\Model\WebhookPushHead_commitAuthor::class],
        'committer' => ['committer', \Acme\GitHub\Generated\Model\WebhookPushHead_commitCommitter::class],
        'distinct' => ['distinct', null],
        'id' => ['id', null],
        'message' => ['message', null],
        'timestamp' => ['timestamp', ['datetime', null]],
        'tree_id' => ['tree_id', null],
        'url' => ['url', null],
        'added' => ['added', ['list', null]],
        'modified' => ['modified', ['list', null]],
        'removed' => ['removed', ['list', null]],
    ];

    /**
     * @param ?list<string> $added
     * @param ?list<string> $modified
     * @param ?list<string> $removed
     */
    public function __construct(
        public WebhookPushHead_commitAuthor $author,
        public WebhookPushHead_commitCommitter $committer,
        public bool $distinct,
        public string $id,
        public string $message,
        public DateTimeImmutable $timestamp,
        public string $tree_id,
        public string $url,
        public ?array $added = null,
        public ?array $modified = null,
        public ?array $removed = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'author' => $this->author,
            'committer' => $this->committer,
            'distinct' => $this->distinct,
            'id' => $this->id,
            'message' => $this->message,
            'timestamp' => $this->timestamp->format(\DateTimeInterface::RFC3339),
            'tree_id' => $this->tree_id,
            'url' => $this->url,
            'added' => $this->added,
            'modified' => $this->modified,
            'removed' => $this->removed,
        ];
    }
}
