<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class Settings implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'plan_downgrades' => ['plan_downgrades', null],
        'settings' => ['settings', \Acme\DigitalOcean\Generated\Model\SettingsSettings::class],
        'tier_coverage' => ['tier_coverage', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'plan_downgrades' => $this->plan_downgrades,
            'settings' => $this->settings,
            'tier_coverage' => $this->tier_coverage,
        ];
    }
}
