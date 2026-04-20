<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ConnectionPoolUpdate
{
    public function __construct(
        public string $db,
        public string $mode,
        public int $size,
        public ?string $user = null,
    ) {
    }
}
