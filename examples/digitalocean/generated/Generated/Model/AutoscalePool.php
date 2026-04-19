<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class AutoscalePool implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'active_resources_count' => ['active_resources_count', null],
        'config' => [
            'config',
            [
                'union',
                [
                    \Acme\DigitalOcean\Generated\Model\AutoscalePoolStaticConfig::class,
                    \Acme\DigitalOcean\Generated\Model\AutoscalePoolDynamicConfig::class,
                ],
                null,
            ],
        ],
        'created_at' => ['created_at', ['datetime', null]],
        'droplet_template' => ['droplet_template', \Acme\DigitalOcean\Generated\Model\AutoscalePoolDropletTemplate::class],
        'id' => ['id', null],
        'name' => ['name', null],
        'status' => ['status', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'current_utilization' => ['current_utilization', \Acme\DigitalOcean\Generated\Model\CurrentUtilization::class],
    ];

    public function __construct(
        public int $active_resources_count,
        public AutoscalePoolStaticConfig|AutoscalePoolDynamicConfig $config,
        public DateTimeImmutable $created_at,
        public AutoscalePoolDropletTemplate $droplet_template,
        public string $id,
        public string $name,
        public string $status,
        public DateTimeImmutable $updated_at,
        public ?CurrentUtilization $current_utilization = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'active_resources_count' => $this->active_resources_count,
            'config' => $this->config,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'droplet_template' => $this->droplet_template,
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'current_utilization' => $this->current_utilization,
        ];
    }
}
