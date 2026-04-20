<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class GitCommit
{
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
}
