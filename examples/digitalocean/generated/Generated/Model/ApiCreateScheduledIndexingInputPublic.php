<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiCreateScheduledIndexingInputPublic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'days' => ['days', ['list', null]],
        'knowledge_base_uuid' => ['knowledge_base_uuid', null],
        'time' => ['time', null],
    ];

    /**
     * @param ?list<int> $days
     */
    public function __construct(
        public ?array $days = null,
        public ?string $knowledge_base_uuid = null,
        public ?string $time = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'days' => $this->days,
            'knowledge_base_uuid' => $this->knowledge_base_uuid,
            'time' => $this->time,
        ];
    }
}
