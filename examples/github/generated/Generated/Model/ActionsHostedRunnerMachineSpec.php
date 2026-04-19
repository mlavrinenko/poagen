<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ActionsHostedRunnerMachineSpec implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'cpu_cores' => ['cpu_cores', null],
        'id' => ['id', null],
        'memory_gb' => ['memory_gb', null],
        'storage_gb' => ['storage_gb', null],
    ];

    public function __construct(
        public int $cpu_cores,
        public string $id,
        public int $memory_gb,
        public int $storage_gb,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'cpu_cores' => $this->cpu_cores,
            'id' => $this->id,
            'memory_gb' => $this->memory_gb,
            'storage_gb' => $this->storage_gb,
        ];
    }
}
