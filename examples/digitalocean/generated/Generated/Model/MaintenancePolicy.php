<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class MaintenancePolicy implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'day' => ['day', null],
        'duration' => ['duration', null],
        'start_time' => ['start_time', null],
    ];

    public function __construct(
        public ?string $day = null,
        public ?string $duration = null,
        public ?string $start_time = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'day' => $this->day,
            'duration' => $this->duration,
            'start_time' => $this->start_time,
        ];
    }
}
