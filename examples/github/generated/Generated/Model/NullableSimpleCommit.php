<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class NullableSimpleCommit
{
    public function __construct(
        public NullableSimpleCommitAuthor $author,
        public NullableSimpleCommitCommitter $committer,
        public string $id,
        public string $message,
        public DateTimeImmutable $timestamp,
        public string $tree_id,
    ) {
    }
}
