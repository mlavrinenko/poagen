<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppEvents
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppEvent> $events
     */
    public function __construct(
        public ?array $events = null,
        public ?PageLinks $links = null,
    ) {
    }
}
