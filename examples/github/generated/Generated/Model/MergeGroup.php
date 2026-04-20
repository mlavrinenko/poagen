<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class MergeGroup
{
    public function __construct(
        public string $base_ref,
        public string $base_sha,
        public SimpleCommit $head_commit,
        public string $head_ref,
        public string $head_sha,
    ) {
    }
}
