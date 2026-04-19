<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AddonsResourceNew implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'app_slug' => ['app_slug', null],
        'metadata' => ['metadata', ['list', \Acme\DigitalOcean\Generated\Model\AddonsResourceMetadata::class]],
        'name' => ['name', null],
        'plan_slug' => ['plan_slug', null],
        'fleet_uuid' => ['fleet_uuid', null],
        'linked_droplet_id' => ['linked_droplet_id', null],
    ];

    /**
     * @param list<\Acme\DigitalOcean\Generated\Model\AddonsResourceMetadata> $metadata
     */
    public function __construct(
        public string $app_slug,
        public array $metadata,
        public string $name,
        public string $plan_slug,
        public ?string $fleet_uuid = null,
        public ?int $linked_droplet_id = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'app_slug' => $this->app_slug,
            'metadata' => $this->metadata,
            'name' => $this->name,
            'plan_slug' => $this->plan_slug,
            'fleet_uuid' => $this->fleet_uuid,
            'linked_droplet_id' => $this->linked_droplet_id,
        ];
    }
}
