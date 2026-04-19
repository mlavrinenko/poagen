<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Droplet implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'backup_ids' => ['backup_ids', ['list', null]],
        'created_at' => ['created_at', ['datetime', null]],
        'disk' => ['disk', null],
        'features' => ['features', ['list', null]],
        'id' => ['id', null],
        'image' => ['image', null],
        'locked' => ['locked', null],
        'memory' => ['memory', null],
        'name' => ['name', null],
        'networks' => ['networks', \Acme\DigitalOcean\Generated\Model\DropletNetworks::class],
        'next_backup_window' => ['next_backup_window', null],
        'region' => ['region', \Acme\DigitalOcean\Generated\Model\Region::class],
        'size' => ['size', \Acme\DigitalOcean\Generated\Model\Size::class],
        'size_slug' => ['size_slug', null],
        'snapshot_ids' => ['snapshot_ids', ['list', null]],
        'status' => ['status', null],
        'tags' => ['tags', ['list', null]],
        'vcpus' => ['vcpus', null],
        'volume_ids' => ['volume_ids', ['list', null]],
        'disk_info' => ['disk_info', ['list', \Acme\DigitalOcean\Generated\Model\DiskInfo::class]],
        'gpu_info' => ['gpu_info', \Acme\DigitalOcean\Generated\Model\GpuInfo::class],
        'kernel' => ['kernel', \Acme\DigitalOcean\Generated\Model\Kernel::class],
        'vpc_uuid' => ['vpc_uuid', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'backup_ids' => $this->backup_ids,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'disk' => $this->disk,
            'features' => $this->features,
            'id' => $this->id,
            'image' => $this->image,
            'locked' => $this->locked,
            'memory' => $this->memory,
            'name' => $this->name,
            'networks' => $this->networks,
            'next_backup_window' => $this->next_backup_window,
            'region' => $this->region,
            'size' => $this->size,
            'size_slug' => $this->size_slug,
            'snapshot_ids' => $this->snapshot_ids,
            'status' => $this->status,
            'tags' => $this->tags,
            'vcpus' => $this->vcpus,
            'volume_ids' => $this->volume_ids,
            'disk_info' => $this->disk_info,
            'gpu_info' => $this->gpu_info,
            'kernel' => $this->kernel,
            'vpc_uuid' => $this->vpc_uuid,
        ];
    }
}
