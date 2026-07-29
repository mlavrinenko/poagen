<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class SearchClientResponseCardsItem
{
    public function __construct(
        public string $barcode,
        public int $card_id,
        public string $code,
        public string $outer_systems_interface_name,
        public ?int $outer_systems_interface_type,
    ) {
    }
}
