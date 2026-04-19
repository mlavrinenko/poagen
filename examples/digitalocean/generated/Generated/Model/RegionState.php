<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class RegionState implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'status' => ['status', null],
        'status_changed_at' => ['status_changed_at', null],
        'thirty_day_uptime_percentage' => ['thirty_day_uptime_percentage', null],
    ];

    public function __construct(
        public ?string $status = null,
        public ?string $status_changed_at = null,
        public ?float $thirty_day_uptime_percentage = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'status' => $this->status,
            'status_changed_at' => $this->status_changed_at,
            'thirty_day_uptime_percentage' => $this->thirty_day_uptime_percentage,
        ];
    }
}
