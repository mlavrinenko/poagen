<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class InvoiceSummary
{
    /**
     * @param ?mixed $credits_and_adjustments
     * @param ?mixed $overages
     * @param ?mixed $product_charges
     * @param ?mixed $taxes
     * @param ?mixed $user_billing_address
     */
    public function __construct(
        public ?string $amount = null,
        public ?string $billing_period = null,
        public $credits_and_adjustments = null,
        public ?string $invoice_id = null,
        public ?string $invoice_uuid = null,
        public $overages = null,
        public $product_charges = null,
        public $taxes = null,
        public $user_billing_address = null,
        public ?string $user_company = null,
        public ?string $user_email = null,
        public ?string $user_name = null,
    ) {
    }
}
