<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class InvoicePreview
{
    public function __construct(
        public ?string $amount = null,
        public ?string $invoice_id = null,
        public ?string $invoice_period = null,
        public ?string $invoice_uuid = null,
        public ?string $updated_at = null,
    ) {
    }
}
