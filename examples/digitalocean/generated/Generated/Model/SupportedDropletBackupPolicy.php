<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class SupportedDropletBackupPolicy implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'name' => ['name', null],
        'possible_days' => ['possible_days', ['list', null]],
        'possible_window_starts' => ['possible_window_starts', ['list', null]],
        'retention_period_days' => ['retention_period_days', null],
        'window_length_hours' => ['window_length_hours', null],
    ];

    /**
     * @param ?list<string> $possible_days
     * @param ?list<int> $possible_window_starts
     */
    public function __construct(
        public ?string $name = null,
        public ?array $possible_days = null,
        public ?array $possible_window_starts = null,
        public ?int $retention_period_days = null,
        public ?int $window_length_hours = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'possible_days' => $this->possible_days,
            'possible_window_starts' => $this->possible_window_starts,
            'retention_period_days' => $this->retention_period_days,
            'window_length_hours' => $this->window_length_hours,
        ];
    }
}
