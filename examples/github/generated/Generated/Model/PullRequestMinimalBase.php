<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PullRequestMinimalBase
{
    public function __construct(
        public string $ref,
        public PullRequestMinimalBaseRepo $repo,
        public string $sha,
    ) {
    }
}
