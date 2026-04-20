<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class Tags
{
    /**
     * @param ?array<string, mixed> $resources
     */
    public function __construct(
        public ?string $name = null,
        public ?array $resources = null,
    ) {
    }
}
