<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CommitSearchResultItemCommit implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'author' => ['author', \Acme\GitHub\Generated\Model\CommitSearchResultItemCommitAuthor::class],
        'comment_count' => ['comment_count', null],
        'committer' => ['committer', \Acme\GitHub\Generated\Model\NullableGitUser::class],
        'message' => ['message', null],
        'tree' => ['tree', \Acme\GitHub\Generated\Model\CommitSearchResultItemCommitTree::class],
        'url' => ['url', null],
        'verification' => ['verification', \Acme\GitHub\Generated\Model\Verification::class],
    ];

    public function __construct(
        public CommitSearchResultItemCommitAuthor $author,
        public int $comment_count,
        public NullableGitUser $committer,
        public string $message,
        public CommitSearchResultItemCommitTree $tree,
        public string $url,
        public ?Verification $verification = null,
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
