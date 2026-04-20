<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ReviewCustomGatesCommentRequired
{
    public function __construct(
        public string $comment,
        public string $environment_name,
    ) {
    }
}
