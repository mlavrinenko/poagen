<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class EventsLogs
{
    public function __construct(
        public ?string $cluster_name = null,
        public ?string $create_time = null,
        public ?string $event_type = null,
        public ?string $id = null,
    ) {
    }
}
