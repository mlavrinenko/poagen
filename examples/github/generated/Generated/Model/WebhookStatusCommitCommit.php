<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookStatusCommitCommit implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'author' => ['author', null],
        'comment_count' => ['comment_count', null],
        'committer' => ['committer', null],
        'message' => ['message', null],
        'tree' => ['tree', \Acme\GitHub\Generated\Model\WebhookStatusCommitCommitTree::class],
        'url' => ['url', null],
        'verification' => ['verification', \Acme\GitHub\Generated\Model\WebhookStatusCommitCommitVerification::class],
    ];

    /**
     * @param mixed $author
     * @param mixed $committer
     */
    public function __construct(
        public $author,
        public int $comment_count,
        public $committer,
        public string $message,
        public WebhookStatusCommitCommitTree $tree,
        public string $url,
        public WebhookStatusCommitCommitVerification $verification,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'author' => $this->author,
            'comment_count' => $this->comment_count,
            'committer' => $this->committer,
            'message' => $this->message,
            'tree' => $this->tree,
            'url' => $this->url,
            'verification' => $this->verification,
        ];
    }
}
