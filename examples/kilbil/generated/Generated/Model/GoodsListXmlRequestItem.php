<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GoodsListXmlRequestItem
{
    /**
     * @param list<GoodsListXmlRequestItemInsideItem> $inside
     */
    public function __construct(
        public int $ID,
        public array $inside,
    ) {
    }
}
