<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GetDetailingByMoveRequest
{
    public function __construct(
        public ?int $id = null,
        public ?string $move_date = null,
        public ?string $move_id = null,
    ) {
    }
}
