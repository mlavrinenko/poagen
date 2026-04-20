<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class GistCommitChange_status
{
    public function __construct(
        public ?int $additions = null,
        public ?int $deletions = null,
        public ?int $total = null,
    ) {
    }
}
