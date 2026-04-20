<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AlertUpdatable
{
    public function __construct(
        public ?string $comparison = null,
        public ?string $name = null,
        public ?Notification $notifications = null,
        public ?string $period = null,
        public ?int $threshold = null,
        public ?string $type = null,
    ) {
    }
}
