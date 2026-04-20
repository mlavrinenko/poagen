<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class KafkaTopicVerbose
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\KafkaTopicPartition> $partitions
     */
    public function __construct(
        public ?KafkaTopicConfig $config = null,
        public ?string $name = null,
        public ?array $partitions = null,
        public ?int $replication_factor = null,
        public ?string $state = null,
    ) {
    }
}
