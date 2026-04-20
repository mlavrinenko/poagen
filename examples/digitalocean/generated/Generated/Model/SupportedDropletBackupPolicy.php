<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class SupportedDropletBackupPolicy
{
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
}
