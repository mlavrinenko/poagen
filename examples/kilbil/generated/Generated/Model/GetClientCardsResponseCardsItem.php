<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GetClientCardsResponseCardsItem
{
    public function __construct(
        public ?string $barcode = null,
        public ?int $card_id = null,
        public ?string $code = null,
        public ?string $outer_systems_interface_name = null,
        public ?int $outer_systems_interface_type = null,
    ) {
    }
}
