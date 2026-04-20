<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CommitSearchResultItemCommit
{
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
}
