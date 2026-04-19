<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AssociatedResourceStatusResources implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'floating_ips' => ['floating_ips', ['list', \Acme\DigitalOcean\Generated\Model\DestroyedAssociatedResource::class]],
        'reserved_ips' => ['reserved_ips', ['list', \Acme\DigitalOcean\Generated\Model\DestroyedAssociatedResource::class]],
        'snapshots' => ['snapshots', ['list', \Acme\DigitalOcean\Generated\Model\DestroyedAssociatedResource::class]],
        'volume_snapshots' => [
            'volume_snapshots',
            ['list', \Acme\DigitalOcean\Generated\Model\DestroyedAssociatedResource::class],
        ],
        'volumes' => ['volumes', ['list', \Acme\DigitalOcean\Generated\Model\DestroyedAssociatedResource::class]],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\DestroyedAssociatedResource> $floating_ips
     * @param ?list<\Acme\DigitalOcean\Generated\Model\DestroyedAssociatedResource> $reserved_ips
     * @param ?list<\Acme\DigitalOcean\Generated\Model\DestroyedAssociatedResource> $snapshots
     * @param ?list<\Acme\DigitalOcean\Generated\Model\DestroyedAssociatedResource> $volume_snapshots
     * @param ?list<\Acme\DigitalOcean\Generated\Model\DestroyedAssociatedResource> $volumes
     */
    public function __construct(
        public ?array $floating_ips = null,
        public ?array $reserved_ips = null,
        public ?array $snapshots = null,
        public ?array $volume_snapshots = null,
        public ?array $volumes = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'floating_ips' => $this->floating_ips,
            'reserved_ips' => $this->reserved_ips,
            'snapshots' => $this->snapshots,
            'volume_snapshots' => $this->volume_snapshots,
            'volumes' => $this->volumes,
        ];
    }
}
