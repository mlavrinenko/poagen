<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class InvoicePreview implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'amount' => ['amount', null],
        'invoice_id' => ['invoice_id', null],
        'invoice_period' => ['invoice_period', null],
        'invoice_uuid' => ['invoice_uuid', null],
        'updated_at' => ['updated_at', null],
    ];

    public function __construct(
        public ?string $amount = null,
        public ?string $invoice_id = null,
        public ?string $invoice_period = null,
        public ?string $invoice_uuid = null,
        public ?string $updated_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'amount' => $this->amount,
            'invoice_id' => $this->invoice_id,
            'invoice_period' => $this->invoice_period,
            'invoice_uuid' => $this->invoice_uuid,
            'updated_at' => $this->updated_at,
        ];
    }
}
