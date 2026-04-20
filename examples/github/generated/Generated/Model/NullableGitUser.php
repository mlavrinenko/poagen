<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class NullableGitUser
{
    public function __construct(
        public ?DateTimeImmutable $date = null,
        public ?string $email = null,
        public ?string $name = null,
    ) {
    }
}
