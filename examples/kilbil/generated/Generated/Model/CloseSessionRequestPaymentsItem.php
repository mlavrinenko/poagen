<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use Acme\Kilbil\Generated\Enum\CloseSessionRequestPaymentsItemType;

final readonly class CloseSessionRequestPaymentsItem
{
    public function __construct(
        public ?float $payment_amount = null,
        public ?CloseSessionRequestPaymentsItemType $type = null,
    ) {
    }
}
