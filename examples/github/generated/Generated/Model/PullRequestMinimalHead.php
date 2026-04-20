<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PullRequestMinimalHead
{
    public function __construct(
        public string $ref,
        public PullRequestMinimalHeadRepo $repo,
        public string $sha,
    ) {
    }
}
