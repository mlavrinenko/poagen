<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PagesSourceHash
{
    public function __construct(
        public string $branch,
        public string $path,
    ) {
    }
}
