<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class ProcessSaleResponseBillData
{
    /**
     * @param list<ProcessSaleResponseBillDataItemsItem> $items
     */
    public function __construct(
        public float $bonus_in,
        public float $bonus_out,
        public float $discount,
        public float $discounted_total,
        public array $items,
        public float $total,
    ) {
    }
}
