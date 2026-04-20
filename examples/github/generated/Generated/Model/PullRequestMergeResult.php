<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PullRequestMergeResult
{
    public function __construct(
        public bool $merged,
        public string $message,
        public string $sha,
    ) {
    }
}
