<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class GitTagObject
{
    public function __construct(
        public string $sha,
        public string $type,
        public string $url,
    ) {
    }
}
