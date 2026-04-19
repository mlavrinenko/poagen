<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiStarMetric implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'metric_uuid' => ['metric_uuid', null],
        'name' => ['name', null],
        'success_threshold' => ['success_threshold', null],
        'success_threshold_pct' => ['success_threshold_pct', null],
    ];

    public function __construct(
        public ?string $metric_uuid = null,
        public ?string $name = null,
        public ?float $success_threshold = null,
        public ?int $success_threshold_pct = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'metric_uuid' => $this->metric_uuid,
            'name' => $this->name,
            'success_threshold' => $this->success_threshold,
            'success_threshold_pct' => $this->success_threshold_pct,
        ];
    }
}
