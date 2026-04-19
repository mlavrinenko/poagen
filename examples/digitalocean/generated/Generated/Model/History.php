<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class History implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'current_instance_count' => ['current_instance_count', null],
        'desired_instance_count' => ['desired_instance_count', null],
        'history_event_id' => ['history_event_id', null],
        'reason' => ['reason', null],
        'status' => ['status', null],
        'updated_at' => ['updated_at', ['datetime', null]],
    ];

    public function __construct(
        public DateTimeImmutable $created_at,
        public int $current_instance_count,
        public int $desired_instance_count,
        public string $history_event_id,
        public string $reason,
        public string $status,
        public DateTimeImmutable $updated_at,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'current_instance_count' => $this->current_instance_count,
            'desired_instance_count' => $this->desired_instance_count,
            'history_event_id' => $this->history_event_id,
            'reason' => $this->reason,
            'status' => $this->status,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
        ];
    }
}
