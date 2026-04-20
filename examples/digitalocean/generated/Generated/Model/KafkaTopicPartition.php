<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class KafkaTopicPartition
{
    /**
     * @param ?list<array<string, mixed>> $consumer_groups
     */
    public function __construct(
        public ?array $consumer_groups = null,
        public ?int $earliest_offset = null,
        public ?int $id = null,
        public ?int $in_sync_replicas = null,
        public ?int $size = null,
    ) {
    }
}
