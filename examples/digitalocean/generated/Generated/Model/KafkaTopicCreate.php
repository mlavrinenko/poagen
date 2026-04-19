<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class KafkaTopicCreate implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'config' => ['config', \Acme\DigitalOcean\Generated\Model\KafkaTopicConfig::class],
        'name' => ['name', null],
        'partition_count' => ['partition_count', null],
        'replication_factor' => ['replication_factor', null],
    ];

    public function __construct(
        public ?KafkaTopicConfig $config = null,
        public ?string $name = null,
        public ?int $partition_count = null,
        public ?int $replication_factor = null,
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
            'partition_count' => $this->partition_count,
            'replication_factor' => $this->replication_factor,
        ];
    }
}
