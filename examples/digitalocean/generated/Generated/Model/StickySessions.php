<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class StickySessions
{
    public function __construct(
        public ?string $cookie_name = null,
        public ?int $cookie_ttl_seconds = null,
        public ?string $type = null,
    ) {
    }
}
