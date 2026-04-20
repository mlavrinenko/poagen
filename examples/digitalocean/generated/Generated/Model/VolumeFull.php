<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class VolumeFull
{
    /**
     * @param ?list<int> $droplet_ids
     * @param ?mixed $region
     */
    public function __construct(
        public ?string $created_at = null,
        public ?string $description = null,
        public ?array $droplet_ids = null,
        public ?string $filesystem_label = null,
        public ?string $filesystem_type = null,
        public ?string $id = null,
        public ?string $name = null,
        public $region = null,
        public ?int $size_gigabytes = null,
        public ?TagsArrayRead $tags = null,
    ) {
    }
}
