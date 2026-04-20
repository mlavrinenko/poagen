<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class BasicError
{
    public function __construct(
        public ?string $documentation_url = null,
        public ?string $message = null,
        public ?string $status = null,
        public ?string $url = null,
    ) {
    }
}
