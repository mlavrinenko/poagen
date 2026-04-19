<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class BillingUsageSummaryReportOrg implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'organization' => ['organization', null],
        'timePeriod' => ['timePeriod', \Acme\GitHub\Generated\Model\BillingUsageSummaryReportOrgTimePeriod::class],
        'usageItems' => ['usageItems', ['list', null]],
        'product' => ['product', null],
        'repository' => ['repository', null],
        'sku' => ['sku', null],
    ];

    /**
     * @param list<array<string, mixed>> $usageItems
     */
    public function __construct(
        public string $organization,
        public BillingUsageSummaryReportOrgTimePeriod $timePeriod,
        public array $usageItems,
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
            'organization' => $this->organization,
            'timePeriod' => $this->timePeriod,
            'usageItems' => $this->usageItems,
            'product' => $this->product,
            'repository' => $this->repository,
            'sku' => $this->sku,
        ];
    }
}
