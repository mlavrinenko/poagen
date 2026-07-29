<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class ReservedPromocodeRequest
{
    public function __construct(
        public string $promo_code,
        public bool $set_reserved,
    ) {
    }
}
