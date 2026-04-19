<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class FileCommitCommit implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'author' => ['author', \Acme\GitHub\Generated\Model\FileCommitCommitAuthor::class],
        'committer' => ['committer', \Acme\GitHub\Generated\Model\FileCommitCommitCommitter::class],
        'html_url' => ['html_url', null],
        'message' => ['message', null],
        'node_id' => ['node_id', null],
        'parents' => ['parents', ['list', null]],
        'sha' => ['sha', null],
        'tree' => ['tree', \Acme\GitHub\Generated\Model\FileCommitCommitTree::class],
        'url' => ['url', null],
        'verification' => ['verification', \Acme\GitHub\Generated\Model\FileCommitCommitVerification::class],
    ];

    /**
     * @param ?list<array<string, mixed>> $parents
     */
    public function __construct(
        public ?FileCommitCommitAuthor $author = null,
        public ?FileCommitCommitCommitter $committer = null,
        public ?string $html_url = null,
        public ?string $message = null,
        public ?string $node_id = null,
        public ?array $parents = null,
        public ?string $sha = null,
        public ?FileCommitCommitTree $tree = null,
        public ?string $url = null,
        public ?FileCommitCommitVerification $verification = null,
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
