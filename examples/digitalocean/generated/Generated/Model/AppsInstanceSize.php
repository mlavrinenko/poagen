<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\InstanceSizeCpuType;
use JsonSerializable;

final readonly class AppsInstanceSize implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'bandwidth_allowance_gib' => ['bandwidth_allowance_gib', null],
        'cpu_type' => ['cpu_type', ['enum', \Acme\DigitalOcean\Generated\Enum\InstanceSizeCpuType::class]],
        'cpus' => ['cpus', null],
        'deprecation_intent' => ['deprecation_intent', null],
        'memory_bytes' => ['memory_bytes', null],
        'name' => ['name', null],
        'scalable' => ['scalable', null],
        'single_instance_only' => ['single_instance_only', null],
        'slug' => ['slug', null],
        'tier_downgrade_to' => ['tier_downgrade_to', null],
        'tier_slug' => ['tier_slug', null],
        'tier_upgrade_to' => ['tier_upgrade_to', null],
        'usd_per_month' => ['usd_per_month', null],
        'usd_per_second' => ['usd_per_second', null],
    ];

    public function __construct(
        public ?string $bandwidth_allowance_gib = null,
        public ?InstanceSizeCpuType $cpu_type = null,
        public ?string $cpus = null,
        public ?bool $deprecation_intent = null,
        public ?string $memory_bytes = null,
        public ?string $name = null,
        public ?bool $scalable = null,
        public ?bool $single_instance_only = null,
        public ?string $slug = null,
        public ?string $tier_downgrade_to = null,
        public ?string $tier_slug = null,
        public ?string $tier_upgrade_to = null,
        public ?string $usd_per_month = null,
        public ?string $usd_per_second = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'bandwidth_allowance_gib' => $this->bandwidth_allowance_gib,
            'cpu_type' => $this->cpu_type,
            'cpus' => $this->cpus,
            'deprecation_intent' => $this->deprecation_intent,
            'memory_bytes' => $this->memory_bytes,
            'name' => $this->name,
            'scalable' => $this->scalable,
            'single_instance_only' => $this->single_instance_only,
            'slug' => $this->slug,
            'tier_downgrade_to' => $this->tier_downgrade_to,
            'tier_slug' => $this->tier_slug,
            'tier_upgrade_to' => $this->tier_upgrade_to,
            'usd_per_month' => $this->usd_per_month,
            'usd_per_second' => $this->usd_per_second,
        ];
    }
}
