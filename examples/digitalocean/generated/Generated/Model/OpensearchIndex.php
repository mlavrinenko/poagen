<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class OpensearchIndex
{
    public function __construct(
        public ?DateTimeImmutable $created_time = null,
        public ?string $health = null,
        public ?string $index_name = null,
        public ?int $number_of_replicas = null,
        public ?int $number_of_shards = null,
        public ?int $size = null,
        public ?string $status = null,
    ) {
    }
}
