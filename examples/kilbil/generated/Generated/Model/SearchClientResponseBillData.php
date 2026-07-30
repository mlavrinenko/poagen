<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class SearchClientResponseBillData
{
    /**
     * @param list<SearchClientResponseBillDataItemsItem> $items
     */
    public function __construct(
        public array $items,
    ) {
    }
}
