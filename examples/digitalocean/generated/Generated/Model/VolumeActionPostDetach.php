<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\RegionSlug;

final readonly class VolumeActionPostDetach
{
    public function __construct(
        public VolumeActionDropletId $droplet_id,
        public string $type,
        public ?RegionSlug $region = null,
    ) {
    }
}
