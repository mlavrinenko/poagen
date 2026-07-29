<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GetActionsListRequest
{
    /**
     * @param list<string> $goods
     */
    public function __construct(
        public array $goods,
        public ?int $trade_object_id,
    ) {
    }
}
