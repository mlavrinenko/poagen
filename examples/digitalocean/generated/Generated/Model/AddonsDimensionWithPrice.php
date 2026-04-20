<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AddonsDimensionWithPrice
{
    /**
     * @param list<\Acme\DigitalOcean\Generated\Model\AddonsDimensionVolumeWithPrice> $volumes
     */
    public function __construct(
        public string $display_name,
        public string $feature_name,
        public int $id,
        public string $sku,
        public string $slug,
        public array $volumes,
    ) {
    }
}
