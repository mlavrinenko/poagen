<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppComponentHealth implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'cpu_usage_percent' => ['cpu_usage_percent', null],
        'memory_usage_percent' => ['memory_usage_percent', null],
        'name' => ['name', null],
        'replicas_desired' => ['replicas_desired', null],
        'replicas_ready' => ['replicas_ready', null],
        'state' => ['state', null],
    ];

    public function __construct(
        public ?float $cpu_usage_percent = null,
        public ?float $memory_usage_percent = null,
        public ?string $name = null,
        public ?int $replicas_desired = null,
        public ?int $replicas_ready = null,
        public ?string $state = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'cpu_usage_percent' => $this->cpu_usage_percent,
            'memory_usage_percent' => $this->memory_usage_percent,
            'name' => $this->name,
            'replicas_desired' => $this->replicas_desired,
            'replicas_ready' => $this->replicas_ready,
            'state' => $this->state,
        ];
    }
}
