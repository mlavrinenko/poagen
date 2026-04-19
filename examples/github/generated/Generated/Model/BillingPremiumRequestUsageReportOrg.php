<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class BillingPremiumRequestUsageReportOrg implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'organization' => ['organization', null],
        'timePeriod' => ['timePeriod', \Acme\GitHub\Generated\Model\BillingPremiumRequestUsageReportOrgTimePeriod::class],
        'usageItems' => ['usageItems', ['list', null]],
        'model' => ['model', null],
        'product' => ['product', null],
        'user' => ['user', null],
    ];

    /**
     * @param list<array<string, mixed>> $usageItems
     */
    public function __construct(
        public string $organization,
        public BillingPremiumRequestUsageReportOrgTimePeriod $timePeriod,
        public array $usageItems,
        public ?string $model = null,
        public ?string $product = null,
        public ?string $user = null,
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
            'model' => $this->model,
            'product' => $this->product,
            'user' => $this->user,
        ];
    }
}
