<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class DatabaseMaintenanceWindow implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'day' => ['day', null],
        'hour' => ['hour', null],
        'description' => ['description', ['list', null]],
        'pending' => ['pending', null],
    ];

    /**
     * @param ?list<string> $description
     */
    public function __construct(
        public string $day,
        public string $hour,
        public ?array $description = null,
        public ?bool $pending = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'day' => $this->day,
            'hour' => $this->hour,
            'description' => $this->description,
            'pending' => $this->pending,
        ];
    }
}
