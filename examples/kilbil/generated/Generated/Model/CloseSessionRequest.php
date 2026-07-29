<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use Acme\Kilbil\ValueObject\Timestamp;

final readonly class CloseSessionRequest
{
    /**
     * @param list<\Acme\Kilbil\Generated\Model\CloseSessionRequestPaymentsItem> $payments
     */
    public function __construct(
        public array $payments,
        public Timestamp $shift_close_dt,
        public int $shift_number,
    ) {
    }
}
