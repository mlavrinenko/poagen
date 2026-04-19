<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class DropletBackupPolicy implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'hour' => ['hour', null],
        'plan' => ['plan', null],
        'retention_period_days' => ['retention_period_days', null],
        'weekday' => ['weekday', null],
        'window_length_hours' => ['window_length_hours', null],
    ];

    public function __construct(
        public ?int $hour = null,
        public ?string $plan = null,
        public ?int $retention_period_days = null,
        public ?string $weekday = null,
        public ?int $window_length_hours = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'hour' => $this->hour,
            'plan' => $this->plan,
            'retention_period_days' => $this->retention_period_days,
            'weekday' => $this->weekday,
            'window_length_hours' => $this->window_length_hours,
        ];
    }
}
