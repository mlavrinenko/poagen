<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ApiResourceUsage implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'measurements' => ['measurements', ['list', \Acme\DigitalOcean\Generated\Model\ApiUsageMeasurement::class]],
        'resource_uuid' => ['resource_uuid', null],
        'start' => ['start', ['datetime', null]],
        'stop' => ['stop', ['datetime', null]],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiUsageMeasurement> $measurements
     */
    public function __construct(
        public ?array $measurements = null,
        public ?string $resource_uuid = null,
        public ?DateTimeImmutable $start = null,
        public ?DateTimeImmutable $stop = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'measurements' => $this->measurements,
            'resource_uuid' => $this->resource_uuid,
            'start' => $this->start?->format(\DateTimeInterface::RFC3339),
            'stop' => $this->stop?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
