<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use Acme\Kilbil\Generated\Enum\ConfirmSaleRequestPaymentsItemType;

final readonly class ConfirmSaleRequestPaymentsItem
{
    public function __construct(
        public float $payment_amount,
        public ConfirmSaleRequestPaymentsItemType $type,
        public ?string $gift_card_barcode = null,
    ) {
    }
}
