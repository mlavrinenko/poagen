<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class ProcessSaleResponse
{
    /**
     * @param list<\Acme\Kilbil\Generated\Model\ProcessSaleResponseBillBodyItem> $_bill_body
     * @param ?list<\Acme\Kilbil\Generated\Model\ProcessSaleResponseCashierMessagesItem> $cashier_messages
     * @param ?list<mixed> $coupons_out
     */
    public function __construct(
        public array $_bill_body,
        public ProcessSaleResponseBillData $_bill_data,
        public ?string $_bill_footer,
        public ?string $_bill_header,
        public string $result_code,
        public string $result_text,
        public ?array $cashier_messages = null,
        public ?array $coupons_out = null,
    ) {
    }
}
