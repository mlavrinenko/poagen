<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class BillingHistory implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'amount' => ['amount', null],
        'date' => ['date', ['datetime', null]],
        'description' => ['description', null],
        'invoice_id' => ['invoice_id', null],
        'invoice_uuid' => ['invoice_uuid', null],
        'type' => ['type', null],
    ];

    public function __construct(
        public ?string $amount = null,
        public ?DateTimeImmutable $date = null,
        public ?string $description = null,
        public ?string $invoice_id = null,
        public ?string $invoice_uuid = null,
        public ?string $type = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'amount' => $this->amount,
            'date' => $this->date?->format(\DateTimeInterface::RFC3339),
            'description' => $this->description,
            'invoice_id' => $this->invoice_id,
            'invoice_uuid' => $this->invoice_uuid,
            'type' => $this->type,
        ];
    }
}
