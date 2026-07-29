<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GoodsRequestItem
{
    /**
     * @param ?list<string> $BC
     * @param ?list<array<string, mixed>> $inside
     */
    public function __construct(
        public string $code,
        public string $name,
        public ?array $BC = null,
        public ?string $SKU = null,
        public ?bool $delete_mark = null,
        public ?string $full_name = null,
        public ?array $inside = null,
        public ?bool $is_group = null,
        public ?float $price1 = null,
        public ?float $price2 = null,
        public ?float $price3 = null,
        public ?float $price4 = null,
        public ?float $price5 = null,
        public ?string $variant = null,
    ) {
    }
}
