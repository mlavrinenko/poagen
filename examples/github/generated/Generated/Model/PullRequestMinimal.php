<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PullRequestMinimal
{
    public function __construct(
        public PullRequestMinimalBase $base,
        public PullRequestMinimalHead $head,
        public int $id,
        public int $number,
        public string $url,
    ) {
    }
}
