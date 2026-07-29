<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use Acme\Kilbil\Generated\Enum\ProcessSaleRequestClientSearchMode;
use Acme\Kilbil\Generated\Enum\ProcessSaleRequestPosDiscountsAreUsed;
use Acme\Kilbil\Generated\Enum\ProcessSaleRequestType;
use Acme\Kilbil\ValueObject\Timestamp;

final readonly class ProcessSaleRequest
{
    /**
     * @param list<\Acme\Kilbil\Generated\Model\ProcessSaleRequestGoodsDataItem> $goods_data
     */
    public function __construct(
        public float $bonus_out,
        public ?int $client_id,
        public Timestamp $doc_open_dt,
        public array $goods_data,
        public float $max_bonus_out,
        public string $move_id,
        public ProcessSaleRequestType $type,
        public ?Timestamp $card_apply_dt = null,
        public ?ProcessSaleRequestClientSearchMode $client_search_mode = null,
        public ?string $client_search_value = null,
        public ?bool $is_offline = null,
        public ?bool $is_reserved = null,
        public ?ProcessSaleRequestPosDiscountsAreUsed $pos_discounts_are_used = null,
        public ?ProcessSaleRequestPromoCodes $promo_codes = null,
        public ?string $return_doc_dt = null,
        public ?string $return_move_id = null,
        public ?int $shift_number = null,
    ) {
    }
}
