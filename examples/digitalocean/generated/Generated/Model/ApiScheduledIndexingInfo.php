<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ApiScheduledIndexingInfo implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'days' => ['days', ['list', null]],
        'deleted_at' => ['deleted_at', ['datetime', null]],
        'is_active' => ['is_active', null],
        'knowledge_base_uuid' => ['knowledge_base_uuid', null],
        'last_ran_at' => ['last_ran_at', ['datetime', null]],
        'next_run_at' => ['next_run_at', ['datetime', null]],
        'time' => ['time', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'uuid' => ['uuid', null],
    ];

    /**
     * @param ?list<int> $days
     */
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?array $days = null,
        public ?DateTimeImmutable $deleted_at = null,
        public ?bool $is_active = null,
        public ?string $knowledge_base_uuid = null,
        public ?DateTimeImmutable $last_ran_at = null,
        public ?DateTimeImmutable $next_run_at = null,
        public ?string $time = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'days' => $this->days,
            'deleted_at' => $this->deleted_at?->format(\DateTimeInterface::RFC3339),
            'is_active' => $this->is_active,
            'knowledge_base_uuid' => $this->knowledge_base_uuid,
            'last_ran_at' => $this->last_ran_at?->format(\DateTimeInterface::RFC3339),
            'next_run_at' => $this->next_run_at?->format(\DateTimeInterface::RFC3339),
            'time' => $this->time,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'uuid' => $this->uuid,
        ];
    }
}
