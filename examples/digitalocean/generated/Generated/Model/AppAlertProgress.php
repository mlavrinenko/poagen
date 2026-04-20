<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppAlertProgress
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppAlertProgressStep> $steps
     */
    public function __construct(
        public ?array $steps = null,
    ) {
    }
}
