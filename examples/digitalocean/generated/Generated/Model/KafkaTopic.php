<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class KafkaTopic
{
    public function __construct(
        public ?string $name = null,
        public ?int $partition_count = null,
        public ?int $replication_factor = null,
        public ?string $state = null,
    ) {
    }
}
