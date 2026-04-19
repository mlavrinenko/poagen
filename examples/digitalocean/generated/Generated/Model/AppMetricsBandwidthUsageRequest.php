<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class AppMetricsBandwidthUsageRequest implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['app_ids' => ['app_ids', ['list', null]], 'date' => ['date', ['datetime', null]]];

    /**
     * @param list<string> $app_ids
     */
    public function __construct(
        public array $app_ids,
        public ?DateTimeImmutable $date = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'app_ids' => $this->app_ids,
            'date' => $this->date?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
