<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AddonsDimensionVolumeWithPrice
{
    public function __construct(
        public int $id,
        public int $low_volume,
        public int $max_volume,
        public string $price_per_unit,
    ) {
    }
}
