<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class BillingHistory
{
    public function __construct(
        public ?string $amount = null,
        public ?DateTimeImmutable $date = null,
        public ?string $description = null,
        public ?string $invoice_id = null,
        public ?string $invoice_uuid = null,
        public ?string $type = null,
    ) {
    }
}
