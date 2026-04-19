<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\RegionSlug;
use JsonSerializable;

final readonly class VolumesXfs implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'name' => ['name', null],
        'region' => ['region', ['enum', \Acme\DigitalOcean\Generated\Enum\RegionSlug::class]],
        'size_gigabytes' => ['size_gigabytes', null],
        'created_at' => ['created_at', null],
        'description' => ['description', null],
        'droplet_ids' => ['droplet_ids', ['list', null]],
        'filesystem_label' => ['filesystem_label', null],
        'filesystem_type' => ['filesystem_type', null],
        'id' => ['id', null],
        'snapshot_id' => ['snapshot_id', null],
        'tags' => ['tags', \Acme\DigitalOcean\Generated\Model\TagsArray::class],
    ];

    /**
     * @param ?list<int> $droplet_ids
     * @param ?mixed $filesystem_label
     */
    public function __construct(
        public string $name,
        public RegionSlug $region,
        public int $size_gigabytes,
        public ?string $created_at = null,
        public ?string $description = null,
        public ?array $droplet_ids = null,
        public $filesystem_label = null,
        public ?string $filesystem_type = null,
        public ?string $id = null,
        public ?string $snapshot_id = null,
        public ?TagsArray $tags = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'region' => $this->region,
            'size_gigabytes' => $this->size_gigabytes,
            'created_at' => $this->created_at,
            'description' => $this->description,
            'droplet_ids' => $this->droplet_ids,
            'filesystem_label' => $this->filesystem_label,
            'filesystem_type' => $this->filesystem_type,
            'id' => $this->id,
            'snapshot_id' => $this->snapshot_id,
            'tags' => $this->tags,
        ];
    }
}
