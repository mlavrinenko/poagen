<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GetClientCardsRequest
{
    public function __construct(
        public int $client_id,
        public ?int $outer_systems_interface_type = null,
    ) {
    }
}
