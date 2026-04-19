<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AutoscalePoolDynamicConfig implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'max_instances' => ['max_instances', null],
        'min_instances' => ['min_instances', null],
        'cooldown_minutes' => ['cooldown_minutes', null],
        'target_cpu_utilization' => ['target_cpu_utilization', null],
        'target_memory_utilization' => ['target_memory_utilization', null],
    ];

    public function __construct(
        public int $max_instances,
        public int $min_instances,
        public ?int $cooldown_minutes = null,
        public ?float $target_cpu_utilization = null,
        public ?float $target_memory_utilization = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'max_instances' => $this->max_instances,
            'min_instances' => $this->min_instances,
            'cooldown_minutes' => $this->cooldown_minutes,
            'target_cpu_utilization' => $this->target_cpu_utilization,
            'target_memory_utilization' => $this->target_memory_utilization,
        ];
    }
}
