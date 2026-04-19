<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class NullableCodespaceMachine implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'cpus' => ['cpus', null],
        'display_name' => ['display_name', null],
        'memory_in_bytes' => ['memory_in_bytes', null],
        'name' => ['name', null],
        'operating_system' => ['operating_system', null],
        'prebuild_availability' => ['prebuild_availability', null],
        'storage_in_bytes' => ['storage_in_bytes', null],
    ];

    public function __construct(
        public int $cpus,
        public string $display_name,
        public int $memory_in_bytes,
        public string $name,
        public string $operating_system,
        public ?string $prebuild_availability = null,
        public int $storage_in_bytes,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'cpus' => $this->cpus,
            'display_name' => $this->display_name,
            'memory_in_bytes' => $this->memory_in_bytes,
            'name' => $this->name,
            'operating_system' => $this->operating_system,
            'prebuild_availability' => $this->prebuild_availability,
            'storage_in_bytes' => $this->storage_in_bytes,
        ];
    }
}
