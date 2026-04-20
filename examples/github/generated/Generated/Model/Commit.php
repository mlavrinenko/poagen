<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class Commit
{
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
}
