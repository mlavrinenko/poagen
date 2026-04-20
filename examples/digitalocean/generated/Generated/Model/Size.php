<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class Size
{
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
}
