<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class BillingUsageSummaryReportUser implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'timePeriod' => ['timePeriod', \Acme\GitHub\Generated\Model\BillingUsageSummaryReportUserTimePeriod::class],
        'usageItems' => ['usageItems', ['list', null]],
        'user' => ['user', null],
        'product' => ['product', null],
        'repository' => ['repository', null],
        'sku' => ['sku', null],
    ];

    /**
     * @param list<array<string, mixed>> $usageItems
     */
    public function __construct(
        public BillingUsageSummaryReportUserTimePeriod $timePeriod,
        public array $usageItems,
        public string $user,
        public ?string $product = null,
        public ?string $repository = null,
        public ?string $sku = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'timePeriod' => $this->timePeriod,
            'usageItems' => $this->usageItems,
            'user' => $this->user,
            'product' => $this->product,
            'repository' => $this->repository,
            'sku' => $this->sku,
        ];
    }
}
