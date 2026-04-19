<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class AppMetricsBandwidthUsage implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'app_bandwidth_usage' => [
            'app_bandwidth_usage',
            ['list', \Acme\DigitalOcean\Generated\Model\AppMetricsBandwidthUsageDetails::class],
        ],
        'date' => ['date', ['datetime', null]],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppMetricsBandwidthUsageDetails> $app_bandwidth_usage
     */
    public function __construct(
        public ?array $app_bandwidth_usage = null,
        public ?DateTimeImmutable $date = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'app_bandwidth_usage' => $this->app_bandwidth_usage,
            'date' => $this->date?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
