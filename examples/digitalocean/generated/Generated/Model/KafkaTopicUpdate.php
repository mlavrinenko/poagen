<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class KafkaTopicUpdate
{
    public function __construct(
        public ?KafkaTopicConfig $config = null,
        public ?int $partition_count = null,
        public ?int $replication_factor = null,
    ) {
    }
}
