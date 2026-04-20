<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class SimpleCommitCommitter
{
    public function __construct(
        public string $email,
        public string $name,
    ) {
    }
}
