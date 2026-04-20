<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class Settings
{
    /**
     * @param ?array<string, \Acme\DigitalOcean\Generated\Model\PlanDowngrades> $plan_downgrades
     * @param ?array<string, array<string, mixed>> $tier_coverage
     */
    public function __construct(
        public ?array $plan_downgrades = null,
        public ?SettingsSettings $settings = null,
        public ?array $tier_coverage = null,
    ) {
    }
}
