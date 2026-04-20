<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Composition\Generated\Model;

final readonly class FloatingIpCreateReserveToRegion implements FloatingIpCreate
{
    public function __construct(
        public string $region,
    ) {
    }
}
