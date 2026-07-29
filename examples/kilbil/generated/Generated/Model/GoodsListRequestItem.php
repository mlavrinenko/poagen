<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GoodsListRequestItem
{
    /**
     * @param list<\Acme\Kilbil\Generated\Model\GoodsListRequestItemInsideItem> $inside
     */
    public function __construct(
        public int $ID,
        public array $inside,
    ) {
    }
}
