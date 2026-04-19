<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class Size implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'available' => ['available', null],
        'description' => ['description', null],
        'disk' => ['disk', null],
        'memory' => ['memory', null],
        'price_hourly' => ['price_hourly', null],
        'price_monthly' => ['price_monthly', null],
        'regions' => ['regions', ['list', null]],
        'slug' => ['slug', null],
        'transfer' => ['transfer', null],
        'vcpus' => ['vcpus', null],
        'disk_info' => ['disk_info', ['list', \Acme\DigitalOcean\Generated\Model\DiskInfo::class]],
        'gpu_info' => ['gpu_info', \Acme\DigitalOcean\Generated\Model\GpuInfo::class],
    ];

    /**
     * @param list<string> $regions
     * @param ?list<\Acme\DigitalOcean\Generated\Model\DiskInfo> $disk_info
     */
    public function __construct(
        public bool $available,
        public string $description,
        public int $disk,
        public int $memory,
        public float $price_hourly,
        public float $price_monthly,
        public array $regions,
        public string $slug,
        public float $transfer,
        public int $vcpus,
        public ?array $disk_info = null,
        public ?GpuInfo $gpu_info = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'available' => $this->available,
            'description' => $this->description,
            'disk' => $this->disk,
            'memory' => $this->memory,
            'price_hourly' => $this->price_hourly,
            'price_monthly' => $this->price_monthly,
            'regions' => $this->regions,
            'slug' => $this->slug,
            'transfer' => $this->transfer,
            'vcpus' => $this->vcpus,
            'disk_info' => $this->disk_info,
            'gpu_info' => $this->gpu_info,
        ];
    }
}
