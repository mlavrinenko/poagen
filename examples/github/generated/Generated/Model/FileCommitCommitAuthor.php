<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class FileCommitCommitAuthor
{
    public function __construct(
        public ?string $date = null,
        public ?string $email = null,
        public ?string $name = null,
    ) {
    }
}
