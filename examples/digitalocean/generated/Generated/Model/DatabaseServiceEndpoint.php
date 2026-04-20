<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DatabaseServiceEndpoint
{
    public function __construct(
        public ?string $host = null,
        public ?int $port = null,
    ) {
    }
}
