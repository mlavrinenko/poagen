<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class FunctionObject
{
    /**
     * @param ?array<string, mixed> $parameters
     */
    public function __construct(
        public string $name,
        public ?string $description = null,
        public ?array $parameters = null,
    ) {
    }
}
