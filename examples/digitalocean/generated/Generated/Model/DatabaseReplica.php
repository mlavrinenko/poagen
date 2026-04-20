<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class DatabaseReplica
{
    /**
     * @param ?mixed $connection
     * @param ?mixed $do_settings
     * @param ?mixed $private_connection
     * @param ?list<string> $tags
     */
    public function __construct(
        public string $name,
        public $connection = null,
        public ?DateTimeImmutable $created_at = null,
        public $do_settings = null,
        public ?string $id = null,
        public $private_connection = null,
        public ?string $private_network_uuid = null,
        public ?string $region = null,
        public ?string $size = null,
        public ?string $status = null,
        public ?int $storage_size_mib = null,
        public ?array $tags = null,
    ) {
    }
}
