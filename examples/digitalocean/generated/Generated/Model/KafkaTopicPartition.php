<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class KafkaTopicPartition implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'consumer_groups' => ['consumer_groups', ['list', null]],
        'earliest_offset' => ['earliest_offset', null],
        'id' => ['id', null],
        'in_sync_replicas' => ['in_sync_replicas', null],
        'size' => ['size', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'consumer_groups' => $this->consumer_groups,
            'earliest_offset' => $this->earliest_offset,
            'id' => $this->id,
            'in_sync_replicas' => $this->in_sync_replicas,
            'size' => $this->size,
        ];
    }
}
