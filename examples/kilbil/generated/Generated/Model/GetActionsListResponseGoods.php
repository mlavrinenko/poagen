<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GetActionsListResponseGoods
{
    /**
     * @param ?list<GetActionsListResponseGoodsGoodCodeItem> $good_code
     */
    public function __construct(
        public ?array $good_code = null,
    ) {
    }
}
