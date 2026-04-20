<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ProductUsageCharges
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ProductChargeItem> $items
     */
    public function __construct(
        public ?string $amount = null,
        public ?array $items = null,
        public ?string $name = null,
    ) {
    }
}
