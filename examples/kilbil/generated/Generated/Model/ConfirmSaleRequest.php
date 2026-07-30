<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use Acme\Kilbil\Generated\Enum\ConfirmSaleRequestIsOffline;
use Acme\Kilbil\ValueObject\Timestamp;

final readonly class ConfirmSaleRequest
{
    /**
     * @param ?list<ConfirmSaleRequestGoodsDataItem> $goods_data
     * @param ?list<ConfirmSaleRequestPaymentsItem> $payments
     */
    public function __construct(
        public Timestamp $doc_dt,
        public Timestamp $doc_open_dt,
        public string $move_id,
        public ?array $goods_data = null,
        public ?ConfirmSaleRequestIsOffline $is_offline = null,
        public ?string $kkm_doc_number = null,
        public ?string $kkm_fiscal_sign = null,
        public ?string $kkm_serial_number = null,
        public ?array $payments = null,
        public ?Timestamp $shift_open_dt = null,
        public ?string $username = null,
        public ?string $useruid = null,
    ) {
    }
}
