<?php

declare(strict_types=1);

namespace Acme\Petstore\Generated\Model;

final readonly class ApiResponse
{
    public function __construct(
        public ?int $code = null,
        public ?string $message = null,
        public ?string $type = null,
    ) {
    }
}
