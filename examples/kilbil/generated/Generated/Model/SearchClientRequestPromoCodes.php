<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class SearchClientRequestPromoCodes
{
    /**
     * @param ?list<SearchClientRequestPromoCodesCouponsItem> $coupons
     */
    public function __construct(
        public ?array $coupons = null,
    ) {
    }
}
