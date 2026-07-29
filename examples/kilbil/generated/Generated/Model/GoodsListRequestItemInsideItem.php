<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GoodsListRequestItemInsideItem
{
    public function __construct(
        public string $code,
        public ?float $K = null,
        public ?string $variant = null,
    ) {
    }
}
