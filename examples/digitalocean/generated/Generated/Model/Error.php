<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class Error
{
    public function __construct(
        public string $id,
        public string $message,
        public ?string $request_id = null,
    ) {
    }
}
