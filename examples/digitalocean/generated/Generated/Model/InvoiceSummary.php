<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class InvoiceSummary implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'amount' => ['amount', null],
        'billing_period' => ['billing_period', null],
        'credits_and_adjustments' => ['credits_and_adjustments', null],
        'invoice_id' => ['invoice_id', null],
        'invoice_uuid' => ['invoice_uuid', null],
        'overages' => ['overages', null],
        'product_charges' => ['product_charges', null],
        'taxes' => ['taxes', null],
        'user_billing_address' => ['user_billing_address', null],
        'user_company' => ['user_company', null],
        'user_email' => ['user_email', null],
        'user_name' => ['user_name', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'amount' => $this->amount,
            'billing_period' => $this->billing_period,
            'credits_and_adjustments' => $this->credits_and_adjustments,
            'invoice_id' => $this->invoice_id,
            'invoice_uuid' => $this->invoice_uuid,
            'overages' => $this->overages,
            'product_charges' => $this->product_charges,
            'taxes' => $this->taxes,
            'user_billing_address' => $this->user_billing_address,
            'user_company' => $this->user_company,
            'user_email' => $this->user_email,
            'user_name' => $this->user_name,
        ];
    }
}
