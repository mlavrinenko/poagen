<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PullRequestMinimalHeadRepo
{
    public function __construct(
        public int $id,
        public string $name,
        public string $url,
    ) {
    }
}
