<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use Acme\Kilbil\ValueObject\Timestamp;

final readonly class GetDetailingByMoveResponseMoveInfoBonusInDetailItem
{
    public function __construct(
        public ?float $bonus_in = null,
        public ?Timestamp $bonus_in_date = null,
        public ?Timestamp $expire_date = null,
    ) {
    }
}
