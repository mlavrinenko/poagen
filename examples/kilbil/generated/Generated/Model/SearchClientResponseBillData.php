<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class SearchClientResponseBillData
{
    /**
     * @param list<\Acme\Kilbil\Generated\Model\SearchClientResponseBillDataItemsItem> $items
     */
    public function __construct(
        public array $items,
    ) {
    }
}
