<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\RegionSlug;

final readonly class VolumesExt4
{
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
}
