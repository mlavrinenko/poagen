<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class EventsLogs implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'cluster_name' => ['cluster_name', null],
        'create_time' => ['create_time', null],
        'event_type' => ['event_type', null],
        'id' => ['id', null],
    ];

    public function __construct(
        public ?string $cluster_name = null,
        public ?string $create_time = null,
        public ?string $event_type = null,
        public ?string $id = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'cluster_name' => $this->cluster_name,
            'create_time' => $this->create_time,
            'event_type' => $this->event_type,
            'id' => $this->id,
        ];
    }
}
