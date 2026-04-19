<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class BillingDataPoint implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'description' => ['description', null],
        'group_description' => ['group_description', null],
        'region' => ['region', null],
        'sku' => ['sku', null],
        'start_date' => ['start_date', ['date', null]],
        'total_amount' => ['total_amount', null],
        'usage_team_urn' => ['usage_team_urn', null],
    ];

    public function __construct(
        public ?string $description = null,
        public ?string $group_description = null,
        public ?string $region = null,
        public ?string $sku = null,
        public ?DateTimeImmutable $start_date = null,
        public ?string $total_amount = null,
        public ?string $usage_team_urn = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'group_description' => $this->group_description,
            'region' => $this->region,
            'sku' => $this->sku,
            'start_date' => $this->start_date?->format('Y-m-d'),
            'total_amount' => $this->total_amount,
            'usage_team_urn' => $this->usage_team_urn,
        ];
    }
}
