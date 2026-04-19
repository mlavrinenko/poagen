<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Balance implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'account_balance' => ['account_balance', null],
        'generated_at' => ['generated_at', ['datetime', null]],
        'month_to_date_balance' => ['month_to_date_balance', null],
        'month_to_date_usage' => ['month_to_date_usage', null],
    ];

    public function __construct(
        public ?string $account_balance = null,
        public ?DateTimeImmutable $generated_at = null,
        public ?string $month_to_date_balance = null,
        public ?string $month_to_date_usage = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'account_balance' => $this->account_balance,
            'generated_at' => $this->generated_at?->format(\DateTimeInterface::RFC3339),
            'month_to_date_balance' => $this->month_to_date_balance,
            'month_to_date_usage' => $this->month_to_date_usage,
        ];
    }
}
