<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class BranchWithProtection
{
    public function __construct(
        public BranchWithProtection_links $_links,
        public Commit $commit,
        public string $name,
        public bool $protected,
        public BranchProtection $protection,
        public string $protection_url,
        public ?string $pattern = null,
        public ?int $required_approving_review_count = null,
    ) {
    }
}
