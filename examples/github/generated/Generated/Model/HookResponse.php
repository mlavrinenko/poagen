<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class HookResponse
{
    public function __construct(
        public ?int $code = null,
        public ?string $message = null,
        public ?string $status = null,
    ) {
    }
}
