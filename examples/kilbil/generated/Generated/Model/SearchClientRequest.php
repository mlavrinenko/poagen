<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use Acme\Kilbil\Generated\Enum\SearchClientRequestPosDiscountsAreUsed;
use Acme\Kilbil\Generated\Enum\SearchClientRequestSearchMode;
use Acme\Kilbil\ValueObject\Timestamp;

final readonly class SearchClientRequest
{
    /**
     * @param ?list<\Acme\Kilbil\Generated\Model\SearchClientRequestGoodsDataItem> $goods_data
     */
    public function __construct(
        public SearchClientRequestSearchMode $search_mode,
        public string $search_value,
        public ?Timestamp $card_apply_dt = null,
        public ?bool $full_data = null,
        public ?array $goods_data = null,
        public ?SearchClientRequestPosDiscountsAreUsed $pos_discounts_are_used = null,
        public ?SearchClientRequestPromoCodes $promo_codes = null,
    ) {
    }
}
