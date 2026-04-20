<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ReviewCustomGatesStateRequired
{
    public function __construct(
        public string $environment_name,
        public string $state,
        public ?string $comment = null,
    ) {
    }
}
