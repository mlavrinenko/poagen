<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use Acme\Kilbil\ValueObject\Timestamp;

final readonly class GetClientFullBalanceResponseItem
{
    public function __construct(
        public ?string $balance = null,
        public ?Timestamp $begin_dt = null,
        public ?Timestamp $expire_dt = null,
    ) {
    }
}
