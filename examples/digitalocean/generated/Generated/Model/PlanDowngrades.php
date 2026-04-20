<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class PlanDowngrades
{
    /**
     * @param ?list<string> $resources
     */
    public function __construct(
        public ?DateTimeImmutable $effective_at = null,
        public ?array $resources = null,
    ) {
    }
}
