<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class State
{
    public function __construct(
        public ?PreviousOutage $previous_outage = null,
        public ?RegionalState $regions = null,
    ) {
    }
}
