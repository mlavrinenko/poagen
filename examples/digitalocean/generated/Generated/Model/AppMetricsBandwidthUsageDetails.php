<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppMetricsBandwidthUsageDetails implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['app_id' => ['app_id', null], 'bandwidth_bytes' => ['bandwidth_bytes', null]];

    public function __construct(
        public ?string $app_id = null,
        public ?string $bandwidth_bytes = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'app_id' => $this->app_id,
            'bandwidth_bytes' => $this->bandwidth_bytes,
        ];
    }
}
