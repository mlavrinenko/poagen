<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DomainRecord
{
    public function __construct(
        public string $type,
        public ?string $data = null,
        public ?int $flags = null,
        public ?int $id = null,
        public ?string $name = null,
        public ?int $port = null,
        public ?int $priority = null,
        public ?string $tag = null,
        public ?int $ttl = null,
        public ?int $weight = null,
    ) {
    }
}
