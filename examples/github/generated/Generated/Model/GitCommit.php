<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class GitCommit implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'author' => ['author', \Acme\GitHub\Generated\Model\GitCommitAuthor::class],
        'committer' => ['committer', \Acme\GitHub\Generated\Model\GitCommitCommitter::class],
        'html_url' => ['html_url', null],
        'message' => ['message', null],
        'node_id' => ['node_id', null],
        'parents' => ['parents', ['list', null]],
        'sha' => ['sha', null],
        'tree' => ['tree', \Acme\GitHub\Generated\Model\GitCommitTree::class],
        'url' => ['url', null],
        'verification' => ['verification', \Acme\GitHub\Generated\Model\GitCommitVerification::class],
    ];

    /**
     * @param list<array<string, mixed>> $parents
     */
    public function __construct(
        public GitCommitAuthor $author,
        public GitCommitCommitter $committer,
        public string $html_url,
        public string $message,
        public string $node_id,
        public array $parents,
        public string $sha,
        public GitCommitTree $tree,
        public string $url,
        public GitCommitVerification $verification,
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
            'html_url' => $this->html_url,
            'message' => $this->message,
            'node_id' => $this->node_id,
            'parents' => $this->parents,
            'sha' => $this->sha,
            'tree' => $this->tree,
            'url' => $this->url,
            'verification' => $this->verification,
        ];
    }
}
