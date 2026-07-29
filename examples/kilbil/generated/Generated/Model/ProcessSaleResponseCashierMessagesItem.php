<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class ProcessSaleResponseCashierMessagesItem
{
    /**
     * @param list<string> $msg_text
     */
    public function __construct(
        public string $msg_header,
        public array $msg_text,
        public string $msg_type,
    ) {
    }
}
