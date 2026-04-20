<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DomainRecordNs
{
    public function __construct(
        public string $data,
        public ?int $flags = null,
        public string $name,
        public ?string $tag = null,
        public string $type,
        public ?int $id = null,
        public ?int $port = null,
        public ?int $priority = null,
        public ?int $ttl = null,
        public ?int $weight = null,
    ) {
    }
}
