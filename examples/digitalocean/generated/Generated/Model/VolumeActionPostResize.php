<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\RegionSlug;

final readonly class VolumeActionPostResize
{
    public function __construct(
        public int $size_gigabytes,
        public string $type,
        public ?RegionSlug $region = null,
    ) {
    }
}
