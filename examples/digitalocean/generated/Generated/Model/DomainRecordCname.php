<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DomainRecordCname
{
    public function __construct(
        public string $data,
        public string $name,
        public string $type,
        public ?int $flags = null,
        public ?int $id = null,
        public ?int $port = null,
        public ?int $priority = null,
        public ?string $tag = null,
        public ?int $ttl = null,
        public ?int $weight = null,
    ) {
    }
}
