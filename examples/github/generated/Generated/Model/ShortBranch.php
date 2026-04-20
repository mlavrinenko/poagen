<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ShortBranch
{
    public function __construct(
        public ShortBranchCommit $commit,
        public string $name,
        public bool $protected,
        public ?BranchProtection $protection = null,
        public ?string $protection_url = null,
    ) {
    }
}
