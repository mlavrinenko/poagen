<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class BillingPremiumRequestUsageReportUserTimePeriod implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['year' => ['year', null], 'day' => ['day', null], 'month' => ['month', null]];

    public function __construct(
        public int $year,
        public ?int $day = null,
        public ?int $month = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'year' => $this->year,
            'day' => $this->day,
            'month' => $this->month,
        ];
    }
}
