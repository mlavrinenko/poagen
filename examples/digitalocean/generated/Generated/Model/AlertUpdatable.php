<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AlertUpdatable implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'comparison' => ['comparison', null],
        'name' => ['name', null],
        'notifications' => ['notifications', \Acme\DigitalOcean\Generated\Model\Notification::class],
        'period' => ['period', null],
        'threshold' => ['threshold', null],
        'type' => ['type', null],
    ];

    public function __construct(
        public ?string $comparison = null,
        public ?string $name = null,
        public ?Notification $notifications = null,
        public ?string $period = null,
        public ?int $threshold = null,
        public ?string $type = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'comparison' => $this->comparison,
            'name' => $this->name,
            'notifications' => $this->notifications,
            'period' => $this->period,
            'threshold' => $this->threshold,
            'type' => $this->type,
        ];
    }
}
