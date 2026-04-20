<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DatabaseMaintenanceWindow
{
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
}
