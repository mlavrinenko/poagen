<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class FileCommit
{
    public function __construct(
        public FileCommitCommit $commit,
        public FileCommitContent $content,
    ) {
    }
}
