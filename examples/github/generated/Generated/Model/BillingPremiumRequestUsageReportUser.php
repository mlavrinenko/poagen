<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class BillingPremiumRequestUsageReportUser implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'timePeriod' => ['timePeriod', \Acme\GitHub\Generated\Model\BillingPremiumRequestUsageReportUserTimePeriod::class],
        'usageItems' => ['usageItems', ['list', null]],
        'user' => ['user', null],
        'model' => ['model', null],
        'product' => ['product', null],
    ];

    /**
     * @param list<array<string, mixed>> $usageItems
     */
    public function __construct(
        public BillingPremiumRequestUsageReportUserTimePeriod $timePeriod,
        public array $usageItems,
        public string $user,
        public ?string $model = null,
        public ?string $product = null,
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
            'model' => $this->model,
            'product' => $this->product,
        ];
    }
}
