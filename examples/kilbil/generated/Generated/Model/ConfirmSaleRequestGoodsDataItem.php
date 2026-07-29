<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class ConfirmSaleRequestGoodsDataItem
{
    public function __construct(
        public string $code,
        public float $discounted_total,
        public float $quantity,
    ) {
    }
}
