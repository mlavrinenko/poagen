<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GetActionsListResponse
{
    /**
     * @param ?list<\Acme\Kilbil\Generated\Model\GetActionsListResponseActionsItem> $actions
     */
    public function __construct(
        public string $result_code,
        public string $result_text,
        public ?array $actions = null,
        public ?GetActionsListResponseGoods $goods = null,
    ) {
    }
}
