<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class FileCommitCommit
{
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
}
