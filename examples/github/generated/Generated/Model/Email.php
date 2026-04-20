<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class Email
{
    public function __construct(
        public string $email,
        public bool $primary,
        public bool $verified,
        public ?string $visibility = null,
    ) {
    }
}
