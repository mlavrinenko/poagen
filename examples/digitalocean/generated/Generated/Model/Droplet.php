<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class Droplet
{
    /**
     * @param list<int> $backup_ids
     * @param list<string> $features
     * @param mixed $image
     * @param mixed $next_backup_window
     * @param list<int> $snapshot_ids
     * @param list<string> $tags
     * @param list<string> $volume_ids
     * @param ?list<\Acme\DigitalOcean\Generated\Model\DiskInfo> $disk_info
     */
    public function __construct(
        public array $backup_ids,
        public DateTimeImmutable $created_at,
        public int $disk,
        public array $features,
        public int $id,
        public $image,
        public bool $locked,
        public int $memory,
        public string $name,
        public DropletNetworks $networks,
        public $next_backup_window,
        public Region $region,
        public Size $size,
        public string $size_slug,
        public array $snapshot_ids,
        public string $status,
        public array $tags,
        public int $vcpus,
        public array $volume_ids,
        public ?array $disk_info = null,
        public ?GpuInfo $gpu_info = null,
        public ?Kernel $kernel = null,
        public ?string $vpc_uuid = null,
    ) {
    }
}
