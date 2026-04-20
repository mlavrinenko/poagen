<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CommitCommit
{
    public function __construct(
        public NullableGitUser $author,
        public int $comment_count,
        public NullableGitUser $committer,
        public string $message,
        public CommitCommitTree $tree,
        public string $url,
        public ?Verification $verification = null,
    ) {
    }
}
