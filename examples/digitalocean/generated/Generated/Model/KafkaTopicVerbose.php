<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class KafkaTopicVerbose implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'config' => ['config', \Acme\DigitalOcean\Generated\Model\KafkaTopicConfig::class],
        'name' => ['name', null],
        'partitions' => ['partitions', ['list', \Acme\DigitalOcean\Generated\Model\KafkaTopicPartition::class]],
        'replication_factor' => ['replication_factor', null],
        'state' => ['state', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'config' => $this->config,
            'name' => $this->name,
            'partitions' => $this->partitions,
            'replication_factor' => $this->replication_factor,
            'state' => $this->state,
        ];
    }
}
