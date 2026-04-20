<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsListAlertsResponse
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppAlert> $alerts
     */
    public function __construct(
        public ?array $alerts = null,
    ) {
    }
}
