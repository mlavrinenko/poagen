<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class Commit implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'author' => [
            'author',
            [
                'union',
                [\Acme\GitHub\Generated\Model\SimpleUser::class, \Acme\GitHub\Generated\Model\EmptyObject::class],
                null,
            ],
        ],
        'comments_url' => ['comments_url', null],
        'commit' => ['commit', \Acme\GitHub\Generated\Model\CommitCommit::class],
        'committer' => [
            'committer',
            [
                'union',
                [\Acme\GitHub\Generated\Model\SimpleUser::class, \Acme\GitHub\Generated\Model\EmptyObject::class],
                null,
            ],
        ],
        'html_url' => ['html_url', null],
        'node_id' => ['node_id', null],
        'parents' => ['parents', ['list', null]],
        'sha' => ['sha', null],
        'url' => ['url', null],
        'files' => ['files', ['list', \Acme\GitHub\Generated\Model\DiffEntry::class]],
        'stats' => ['stats', \Acme\GitHub\Generated\Model\CommitStats::class],
    ];

    /**
     * @param list<array<string, mixed>> $parents
     * @param ?list<\Acme\GitHub\Generated\Model\DiffEntry> $files
     */
    public function __construct(
        public SimpleUser|EmptyObject|null $author = null,
        public string $comments_url,
        public CommitCommit $commit,
        public SimpleUser|EmptyObject|null $committer = null,
        public string $html_url,
        public string $node_id,
        public array $parents,
        public string $sha,
        public string $url,
        public ?array $files = null,
        public ?CommitStats $stats = null,
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
            'files' => $this->files,
            'stats' => $this->stats,
        ];
    }
}
