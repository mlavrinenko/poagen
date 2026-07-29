<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GetActionsListResponseActionsItemRespondsItem
{
    public function __construct(
        public ?string $do_type = null,
        public ?int $id = null,
        public ?string $unit_type = null,
        public ?float $value = null,
        public ?string $work_type = null,
    ) {
    }
}
