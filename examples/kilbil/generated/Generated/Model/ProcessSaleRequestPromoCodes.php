<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class ProcessSaleRequestPromoCodes
{
    /**
     * @param ?list<ProcessSaleRequestPromoCodesCouponsItem> $coupons
     */
    public function __construct(
        public ?array $coupons = null,
    ) {
    }
}
