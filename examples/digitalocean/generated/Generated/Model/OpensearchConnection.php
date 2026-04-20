<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class OpensearchConnection
{
    public function __construct(
        public ?string $host = null,
        public ?string $password = null,
        public ?int $port = null,
        public ?bool $ssl = null,
        public ?string $uri = null,
        public ?string $user = null,
    ) {
    }
}
