<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ShortBranchCommit
{
    public function __construct(
        public string $sha,
        public string $url,
    ) {
    }
}
