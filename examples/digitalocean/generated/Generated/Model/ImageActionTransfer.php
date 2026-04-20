<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\RegionSlug;

final readonly class ImageActionTransfer
{
    public function __construct(
        public RegionSlug $region,
        public string $type,
    ) {
    }
}
