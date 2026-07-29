<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use Acme\Kilbil\ValueObject\Timestamp;

final readonly class GetDetailingByMoveResponseMoveInfoBonusPresentsItem
{
    public function __construct(
        public ?int $action_id = null,
        public ?string $action_name = null,
        public ?float $bonus_in = null,
        public ?Timestamp $bonus_in_date = null,
        public ?Timestamp $expire_date = null,
    ) {
    }
}
