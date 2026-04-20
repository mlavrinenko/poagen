<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class GitTagTagger
{
    public function __construct(
        public string $date,
        public string $email,
        public string $name,
    ) {
    }
}
