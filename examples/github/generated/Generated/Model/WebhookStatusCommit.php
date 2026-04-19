<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookStatusCommit implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'author' => ['author', \Acme\GitHub\Generated\Model\WebhookStatusCommitAuthor::class],
        'comments_url' => ['comments_url', null],
        'commit' => ['commit', \Acme\GitHub\Generated\Model\WebhookStatusCommitCommit::class],
        'committer' => ['committer', \Acme\GitHub\Generated\Model\WebhookStatusCommitCommitter::class],
        'html_url' => ['html_url', null],
        'node_id' => ['node_id', null],
        'parents' => ['parents', ['list', null]],
        'sha' => ['sha', null],
        'url' => ['url', null],
    ];

    /**
     * @param list<array<string, mixed>> $parents
     */
    public function __construct(
        public WebhookStatusCommitAuthor $author,
        public string $comments_url,
        public WebhookStatusCommitCommit $commit,
        public WebhookStatusCommitCommitter $committer,
        public string $html_url,
        public string $node_id,
        public array $parents,
        public string $sha,
        public string $url,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'author' => $this->author,
            'comments_url' => $this->comments_url,
            'commit' => $this->commit,
            'committer' => $this->committer,
            'html_url' => $this->html_url,
            'node_id' => $this->node_id,
            'parents' => $this->parents,
            'sha' => $this->sha,
            'url' => $this->url,
        ];
    }
}
