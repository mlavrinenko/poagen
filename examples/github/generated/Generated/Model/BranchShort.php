<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class BranchShort
{
    public function __construct(
        public BranchShortCommit $commit,
        public string $name,
        public bool $protected,
    ) {
    }
}
